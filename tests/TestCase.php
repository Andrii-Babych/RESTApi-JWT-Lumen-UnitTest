<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use \Laravel\Lumen\Testing\DatabaseMigrations;

    /** @var array */
    protected static $applicationRefreshed = false;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    /**
     * Creates the application.
     *
     */
    public function createApplication()
    {
        return self::initialize();
    }

    private static $configurationApp = null;

    public static function initialize()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        if (is_null(self::$configurationApp)) {
            $app->environment('testing');

            if (config('database.default') == 'sqlite') {

                $db = app()->make('db');
                $db->connection()->getPdo()->exec("pragma foreign_keys=1");
            }

//            Artisan::call('migrate:reset');
//            Artisan::call('migrate');
//            Artisan::call('db:seed', [
//                '--class' => 'Database\Seeders\UsersTableSeeder'
//            ]);

            self::$configurationApp = $app;
        }

        return $app;
    }


    /**
     * Refresh the application instance.
     *
     * @return void
     */
    protected function forceRefreshApplication()
    {
        if (!is_null($this->app)) {
            $this->app->flush();
        }
        $this->app = null;
        self::$configurationApp = null;
        self::$applicationRefreshed = true;
        parent::refreshApplication();
    }

}
