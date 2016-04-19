<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExampleMetaValuesTableWithCustomNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('example_meta_values', function (Blueprint $table) {
            $table->integer('custom_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('example_meta_values', function (Blueprint $table) {
            $table->dropColumn('custom_number');
        });
    }
}
