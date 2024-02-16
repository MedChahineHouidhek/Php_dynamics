<?php
class Field
{
    public $attributeName;
    public $value;
    public $type;

    function __construct($attributeName, $value, $type = 'string')
    {
        $this->attributeName = $attributeName;
        $this->value = $value;
        $this->type = $type;
    }
}
