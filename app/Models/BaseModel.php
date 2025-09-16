<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
//use PhpJunior\LaravelGlobalSearch\Traits\GlobalSearchable;
use App\Traits\TimestampTrait;
use App\Traits\BooleanTrait;
use App\Traits\FileTrait;
use App\Traits\CaptionTrait;
use App\Traits\OrderTrait;
use App\Traits\FilterTrait;

abstract class BaseModel extends Model
{
    use PivotEventTrait;
    //use GlobalSearchable;
    use TimestampTrait;
    use BooleanTrait;
    use FileTrait;
    use CaptionTrait;
    use OrderTrait;
    use FilterTrait;

    /**
     * @var string
     */
    public static $title = 'name';

    /**
     * @var array
     */
    protected $order = [
        'created_at' => 'asc',
        'id' => 'asc',
    ];

    /**
     * @var string[]
     */
    protected $only = [
        'name',
        'id',
    ];

    /**
     * @return mixed
     */
    public function getEntryTitleAttribute()
    {
        return $this->getAttribute(static::$title);
    }

    /**
     * @return array
     */
    public static function list()
    {
        return static::defaultOrder()->pluck(static::$title, 'id')->toArray();
    }

    /**
     * @return array
     */
    public static function flippedList()
    {
        return array_flip(static::list());
    }
}
