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
        parent::__construct($attributes);

        $this->addsValuesTableIfNotExists();
    }
}
