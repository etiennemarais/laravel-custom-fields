<?php
namespace Metafields;

use Metafields\Types\Number;
use Metafields\Types\Option;
use Metafields\Types\Text;
use Metafields\Types\Toggle;

class FieldTypes
{
    /**
     * @return array
     */
    public static function availableTypes()
    {
        return [
            Number::$type,
            Text::$type,
            Toggle::$type,
            Option::$type,
        ];
    }
}
