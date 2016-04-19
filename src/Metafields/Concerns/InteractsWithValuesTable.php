<?php
namespace Metafields\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

trait InteractsWithValuesTable
{
    public function addsValuesTableIfNotExists() {
        $valuesTableName = $this->table . '_meta_values';

        if (Schema::hasTable($valuesTableName) === false) {
            Artisan::call('make:migration', [
                'name' => 'create_' . $valuesTableName,
                '--create' => $valuesTableName,
            ]);

            Artisan::call('migrate');
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

    public function addValuesTableField(array $metaField)
    {
        $migrationName = 'add_' . $metaField['model'] . '_meta_values_table';
        $schema = $metaField['field_name'] . ':' . $metaField['type'];

        Artisan::call('make:migration:meta', [
            'name' => $migrationName,
            '--classname' => $migrationName . '_with_' . $metaField['field_name'],
            '--schema' => $schema,
        ]);

        Artisan::call('migrate');
    }
}
