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

        static::creating(function($model) {
            /** @var \Metafields\Models\Metafield $model */
            $model->generateFieldNameFromTitle();
            $model->addValuesModelFieldIfNotExists();
        });

        static::updating(function($model) {
            /** @var \Metafields\Models\Metafield $model */
            $model->generateFieldNameFromTitle();
            $model->renameValuesFieldIfChanged();
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

        $fieldCallback = FieldTypes::createSchemaCallback($this->attributes['type'], $fieldName);

        if ($this->hasValuesTableField($fieldName)) {
            return true;
        } else {
            $this->changeValuesTableField($this->attributes['model'], $fieldCallback);
            return true;
        }
    }

    /**
     * // TODO a values field should probably update itself on metafield edit anyway
     * // TODO some thinking needs to go into changing the type, model or enum options
     *
     * @return boolean
     * @throws \ErrorException
     */
    protected function renameValuesFieldIfChanged()
    {
        if ($this->isDirty(['field_name'])) {
            $fieldUpdateCallback = FieldTypes::renameSchemaCallback(
                $this->getOriginal('field_name'),
                $this->attributes['field_name']
            );

            $this->changeValuesTableField($this->attributes['model'], $fieldUpdateCallback);
        } else if ($this->isDirty(['type', 'model', 'options'])) {
            throw new \ErrorException('Cannot change the type, model or options of an added meta field.');
        }

        return true;
    }
}
