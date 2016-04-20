<?php
namespace Metafields\Models;

use Illuminate\Database\Eloquent\Model;
use Metafields\Concerns\InteractsWithValuesTable;
use Metafields\FieldTypes;

class Metafield extends Model
{
    use InteractsWithValuesTable;

    protected $table = 'meta_fields';
    public $timestamps = false;

    public $fillable = [
        'model',
        'title',
        'type',
        'options',
    ];

    public $rules = [
        'model' => 'required',
        'title' => 'required',
        'type' => 'required',
    ];

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateFieldNameFromTitle();
            $model->addValuesModelFieldIfNotExists();
        });

        // TODO handle editing/deleting/saving
    }

    /**
     * @return boolean
     */
    protected function generateFieldNameFromTitle()
    {
        $this->attributes['field_name'] = snake_case($this->attributes['title']);

        if (is_null($this->attributes['field_name'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return boolean
     */
    protected function addValuesModelFieldIfNotExists()
    {
        $fieldName = $this->attributes['field_name'];

        $fieldCallback = FieldTypes::makeCallbackFromType($this->attributes['type'], $fieldName);

        if ($this->hasValuesTableField($fieldName)) {
            return true;
        } else {
            $this->addValuesTableField($this->attributes['model'], $fieldCallback);
            return true;
        }
    }
}
