<?php
namespace Metafields\Concerns;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait InteractsWithValuesTable
{
    public function addsValuesTableIfNotExists() {
        $valuesTableName = $this->table . '_meta_values';

        if (Schema::hasTable($valuesTableName) === false) {
            Schema::create($valuesTableName, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('model_id');
            });
        }
    }

    /**
     * @param string $fieldName
     * @return boolean
     */
    public function hasValuesTableField($fieldName)
    {
        $fields = Schema::getColumnListing($this->table . '_meta_values');

        return (in_array($fieldName, $fields));
    }

    /**
     * @param Closure $fieldCallback
     *
     * example:
     * function(Blueprint $table) {
     *     $table->integer('CustomNumber');
     * }
     */
    public function changeValuesTableField($model, Closure $fieldCallback)
    {
        Schema::table($model . '_meta_values', $fieldCallback);
    }
}
