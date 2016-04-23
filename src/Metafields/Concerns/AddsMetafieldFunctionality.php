<?php
namespace Metafields\Concerns;

trait AddsMetafieldFunctionality
{
    use InteractsWithValuesTable;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->addsValuesTableIfNotExists();
        $this->discoverMetaFields(); # Discovery needs to happen before BaseModel
        parent::__construct($attributes);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if ($this->isMetaField($key)) {
            $this->customAttributes[$key] = $value;
        } else {
            parent::__set($key, $value);
        }
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $this->fillCustomAttributes($attributes);
        parent::fill($attributes);
    }

    /**
     * Fill custom fields
     *
     * @param array $attributes
     */
    public function fillCustomAttributes(array $attributes)
    {
        foreach ($this->metaFields as $name) {
            if (isset($attributes[$name])) {
                $this->customAttributes[$name] = $attributes[$name];
            }
        }
    }

    /**
     * @param array $options
     */
    public function save(array $options = [])
    {
        if (parent::save($options)) {
            $customFieldModel = $this->getMetaFieldsValuesModel();
            $this->customAttributes['model_id'] = (int)$this->id; # Saved ID of model to bind relation to

            foreach ($this->metaFields as $name) {
                $customFieldModel->{$name} = isset($this->customAttributes[$name]) ? $this->customAttributes[$name] : null;
            }

            $customFieldModel->save();
        }
    }
}
