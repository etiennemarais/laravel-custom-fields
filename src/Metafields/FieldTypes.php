<?php
namespace Metafields;

use Illuminate\Database\Schema\Blueprint;
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

    /**
     * @param string $type
     * @param string $fieldName
     * @return \Closure
     */
    public static function createSchemaCallback($type, $fieldName)
    {
        switch ($type) {
            case Number::$type:
                return Number::schemaCallback($fieldName);
                break;
            case Toggle::$type:
                return Toggle::schemaCallback($fieldName);
                break;
            case Text::$type:
            default:
                return Text::schemaCallback($fieldName);
                break;
        }
    }

    /**
     * @param $oldFieldName
     * @param $newFieldName
     * @return \Closure
     */
    public static function renameSchemaCallback($oldFieldName, $newFieldName)
    {
        return function(Blueprint $table) use ($oldFieldName, $newFieldName) {
            $table->renameColumn($oldFieldName, $newFieldName);
        };
    }
}
