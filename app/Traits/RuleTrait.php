<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait RuleTrait
{
    /**
     * @var string
     */
    private static $ruleClassPrefix = 'App\Http\Requests\\';

    /**
     * @var string
     */
    private static $ruleClassSuffix = 'Request';

    /**
     * @param $field
     * @return array|null
     */
    public function fieldRules($field)
    {
        $ruleObject = $this->getRuleObject();

        if (empty($ruleObject)) {
            return null;
        }

        $rules = optional($ruleObject->rules())[$field];

        if (is_array($rules)) {
            $rules = implode('|', $rules);
        }

        
        $rules = explode('|', $rules);

        return $rules;
    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return Str::ucfirst(class_basename($this));
    }

    /**
     * @return mixed
     */
    private function getRuleObject()
    {
        $ruleNamespace = static::$ruleClassPrefix
            . $this->getModelName()
            . static::$ruleClassSuffix;

        if (!class_exists($ruleNamespace)) {
            return null;
        }

        return new $ruleNamespace;
    }
}