<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('field_name', 200); # Generated sanitized name for values table field columns
            $table->enum('type', \Metafields\FieldTypes::availableTypes())->default('string');
            $table->json('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meta_fields');
    }
}
