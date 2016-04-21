<?php
namespace Metafields\Types;

use Illuminate\Database\Schema\Blueprint;

class Text
{
    public static $type = 'string';
    public static $readable = 'Text';
    public static $default = '';
    public static $length = 255;

    /**
     * @param string $field
     * @return \Closure
     */
    public static function schemaCallback($field)
    {
        return function(Blueprint $table) use ($field) {
            $table->{self::$type}($field, self::$length)
                ->default(self::$default)
                ->isNullable();
        };
    }
}
