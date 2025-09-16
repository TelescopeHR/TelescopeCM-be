<?php
namespace App\Traits;

use Schema;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait FilterTrait
{
    /**
     * @var array
     */
    protected static $prefixes = [
        'from_',
        'to_',
    ];

    /**
     * @var string
     */
    public static $sessionModel = 'filterModel';

    /**
     * @var string
     */
    public static $sessionFilters = 'filters';

    /**
     * @var string
     */
    protected static $sessionClear = 'clear';

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFilter($query)
    {
        $where = [];
        $filters = $this->getFilters();

        foreach ($filters as $field => $value) {
            if (isset($value) && $this->hasColumn($field)) {
                $type = $this->columnType($field);
                $field = $this->filedWithoutPrefix($field);
                switch ($type) {
                    case 'string':
                        $where[] = [$field, 'like', '%' . $value . '%'];
                        break;
                    case 'boolean':
                    case 'integer':
                        $where[$field] = (int) $value;
                        break;
                    case 'float':
                        $where[$field] = (float) $value;
                        break;
                    case 'date':
                    case 'datetime':
                        $where[$field] = $value;
                        break;
                    case 'from_date':
                        $where[] = [$field, '>=', $value];
                        break;
                    case 'to_date':
                        $where[] = [$field, '<', Carbon::parse($value)->addDay()];
                        break;
                }
            }
        }

        return $query->where($where);
    }

    /**
     * return null
     */
    public function resetFilters()
    {
        $modelName = $this->modelName();
        $mustClear = (bool) request(static::$sessionClear);

        if ($modelName != session(static::$sessionModel) || $mustClear) {
            session([static::$sessionModel => $modelName]);
            session([static::$sessionFilters => []]);
        }
    }

    /**
     * return null
     */
    public function setupFilters()
    {
        $filters = request()->all();

        if (count($filters) > 0) {
            session([static::$sessionFilters => $filters]);
        }
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public function getFilters()
    {
        $this->resetFilters();
        $this->setupFilters();

        return session(static::$sessionFilters, []);
    }

    /**
     * @param $field
     * @return mixed
     */
    private function hasColumn($field)
    {
        $field = $this->filedWithoutPrefix($field);

        return Schema::hasColumn($this->getTable(), $field);
    }

    /**
     * @param $field
     * @return string
     */
    private function columnType($field)
    {
        return $this->casts[$field] ?? 'string';
    }

    /**
     * @param $field
     * @return string
     */
    private function filedWithoutPrefix($field)
    {
        if (Str::startsWith($field, static::$prefixes)) {
            $field = Str::after($field, '_');
        }

        return $field;
    }

    /**
     * @return string
     */
    private function modelName()
    {
        return Str::ucfirst(class_basename($this));
    }
}
