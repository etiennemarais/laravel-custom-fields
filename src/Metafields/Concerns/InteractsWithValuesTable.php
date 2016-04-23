<?php
namespace Metafields\Concerns;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Metafields\Models\MetaFieldsValues;

trait InteractsWithValuesTable
{
    protected $metaFields = [];
    protected $customAttributes = [];

    /**
     * @param string|null $model
     */
    public function addsValuesTableIfNotExists($model = null)
    {
        $tableName = (is_null($model)) ? $this->table : $model;
        $valuesTableName = $tableName . '_meta_values';

        if (Schema::hasTable($valuesTableName) === false) {
            Schema::create($valuesTableName, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('model_id');
                $table->timestamps(); 
            });
        }
    }

    /**
     * @param string $fieldName
     * @param string $model
     * @return boolean
     */
    public function hasValuesTableField($fieldName, $model = null)
    {
        $tableName = (is_null($model)) ? $this->table : $model;

        $fields = Schema::getColumnListing($tableName . '_meta_values');

        return (in_array($fieldName, $fields));
    }

    /**
     * @param string $model
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

    /**
     * @return MetaFieldsValues
     */
    public function getMetaFieldsValuesModel()
    {
        # Dynamic values model
        return (new MetaFieldsValues())->setTable($this->table . '_meta_values');
    }

    /**
     * @param string $fieldName
     * @return mixed
     */
    protected function isMetaField($fieldName)
    {
        return (in_array($fieldName, $this->metaFields));
    }

    /**
     * Discovers all the meta fields for a model from it's values table.
     */
    protected function discoverMetaFields()
    {
        $this->metaFields = Schema::getColumnListing($this->table . '_meta_values');
    }
}
