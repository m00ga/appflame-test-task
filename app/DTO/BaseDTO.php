<?php

namespace App\DTO;

class BaseDTO
{
    /* Provide attributes in format ['attribute' => 'value'] */
    public function __construct(array $config = [])
    {
        foreach ($config as $attr => $value) {
            if (property_exists($this, $attr)) {
                $this->{$attr} = $value;
            }
        }
    }

    public function toArray(): array
    {
        return get_class_vars(__CLASS__);
    }
}
