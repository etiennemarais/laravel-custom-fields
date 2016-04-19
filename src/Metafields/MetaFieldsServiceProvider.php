<?php
namespace Metafields;

use Illuminate\Support\ServiceProvider;

class MetafieldsServiceProvider extends ServiceProvider
{
//    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/meta_fields.php' => config_path('meta_fields.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/migrations/2016_04_18_152543_create_meta_fields_table.php'
                => database_path('migrations/2016_04_18_152543_create_meta_fields_table.php'),
        ], 'migrations');
    }

    public function register() {
        $this->app->singleton('command.metafield.migrate', function () {
            return app('Metafields\Commands\MigrationMakeFieldCommand');
        });

        $this->commands('command.metafield.migrate');
    }

    /**
     * @return array
     */
//    public function when() {
//        return array('artisan.start');
//    }
}
