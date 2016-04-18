<?php
namespace Metafields;

use Illuminate\Support\ServiceProvider;

class MetaFieldsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/meta_fields.php' => config_path('meta_fields.php'),
            __DIR__ . '/migrations/2016_04_18_152543_create_meta_fields_table.php'
                => database_path('migrations/2016_04_18_152543_create_meta_fields_table.php'),
        ]);
    }

    public function register() {
        // Do nothing yet
    }

    /**
     * @return array
     */
    public function when() {
        return array('artisan.start');
    }
}
