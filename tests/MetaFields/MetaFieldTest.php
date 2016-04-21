<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Schema;
use Metafields\Models\Metafield;

class MetaFieldTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreate_WithNewMetaField_UpdatesValuesTable()
    {
        $metaField = factory(Metafield::class)->create();

        $this->seeInDatabase('meta_fields', [
            'title' => 'Custom Name',
            'model' => 'example',
            'type' => \Metafields\Types\Text::$type,
            'options' => null,
        ]);

        $this->seeSchemaInDatabase($metaField);
    }

    public function testUpdate_WithMetaField_UpdatesMetaFieldAndRenamesValuesTableCollumn()
    {
        $metaField = factory(Metafield::class)->create();

        $metaField->update([
            'title' => 'Updated Name',
        ]);

        $this->seeInDatabase('meta_fields', [
            'title' => 'Updated Name',
            'model' => 'example',
            'type' => \Metafields\Types\Text::$type,
            'options' => null,
        ]);

        $this->seeSchemaInDatabase($metaField);
    }

    public function testUpdate_WithMetaField_ThrowsErrorExceptionOnTypeChange()
    {
        $this->setExpectedException(
            ErrorException::class,
            'Cannot change the type, model or options of an added meta field.'
        );
        $metaField = factory(Metafield::class)->create();

        $metaField->update([
            'type' => 'some other type', # This will break it
        ]);
    }

    public function testDelete_WithMetaField_DropsValuesTableCollumn()
    {
        $metaField = factory(Metafield::class)->create();
        $metaField->delete();

        $this->dontSeeSchemaInDatabase($metaField);
    }

    /**
     * @param Metafield $metaField
     */
    protected function seeSchemaInDatabase(Metafield $metaField)
    {
        $valuesTableName = $metaField->model . '_meta_values';
        $this->assertTrue(Schema::hasTable($valuesTableName));

        $fields = Schema::getColumnListing($valuesTableName);
        $this->assertTrue((in_array($metaField->field_name, $fields)));
    }

    /**
     * @param Metafield $metaField
     */
    protected function dontSeeSchemaInDatabase(Metafield $metaField)
    {
        $valuesTableName = $metaField->model . '_meta_values';
        $this->assertTrue(Schema::hasTable($valuesTableName));

        $fields = Schema::getColumnListing($valuesTableName);
        $this->assertFalse((in_array($metaField->field_name, $fields)));
    }
}
