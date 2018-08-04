<?php namespace App\Domain\Base;


use Illuminate\Database\Eloquent\JsonEncodingException;

trait JsonableTrait
{
    public function toArray()
    {
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $vars[$key] = $value->toArray();
            }
        }
        return $vars;
    }

    public function __toString()
    {
        $vars = $this->toArray();

        return json_encode($vars);
    }
}