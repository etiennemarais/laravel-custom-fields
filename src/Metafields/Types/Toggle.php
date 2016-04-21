<?php
namespace Metafields\Types;


use Illuminate\Database\Schema\Blueprint;

class Toggle
{
    public static $type = 'boolean';
    public static $readable = 'Toggle';
    public static $default = false;

    /**
     * @param string $field
     * @return \Closure
     */
    public static function schemaCallback($field)
    {
        return function(Blueprint $table) use ($field) {
            $table->{self::$type}($field)
                ->default(self::$default)
                ->isNullable();
        };
    }
}
