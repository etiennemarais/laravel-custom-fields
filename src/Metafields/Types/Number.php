<?php
namespace Metafields\Types;

use Illuminate\Database\Schema\Blueprint;

class Number
{
    public static $type = 'integer';
    public static $readable = 'Number';
    public static $default = 0;
    public static $unsigned = true;

    /**
     * @param string $field
     * @return \Closure
     */
    public static function schemaCallback($field)
    {
        return function(Blueprint $table) use ($field) {
            $table->{self::$type}($field, false, self::$unsigned)
                ->isNullable();
        };
    }
}
