<?php

/**
 * This file is part of the Lasalle Software contact form back-end package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2021 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/ls-contactformbackend-pkg
 * @link       https://github.com/LaSalleSoftware/ls-contactformbackend-pkg
 *
 */

namespace Lasallesoftware\Contactformbackend;

// Laravel class
// https://github.com/laravel/framework/blob/5.6/src/Illuminate/Support/ServiceProvider.php
use Illuminate\Support\ServiceProvider;

// Laravel Nova class
use Laravel\Nova\Nova;


class ContactformbackendServiceProvider extends ServiceProvider
{
    use ContactformbackendPoliciesServiceProvider;


    /**
     * Register any application services.
     *
     * "Within the register method, you should only bind things into the service container.
     * You should never attempt to register any event listeners, routes, or any other piece of functionality within
     * the register method. Otherwise, you may accidentally use a service that is provided by a service provider
     * which has not loaded yet."
     * (https://laravel.com/docs/5.6/providers#the-register-method(
     *
     * @return void
     */
    public function register()
    {
        $this->registerNovaResources();
    }

    /**
     * Register the Nova resources for this package.
     *
     * @return void
     */
    protected function registerNovaResources()
    {
        Nova::resources([
            \Lasallesoftware\Contactformbackend\Nova\Resources\Contact_form::class,
        ]);
    }


    /**
     * Bootstrap any package services.
     *
     * "So, what if we need to register a view composer within our service provider?
     * This should be done within the boot method. This method is called after all other service providers
     * have been registered, meaning you have access to all other services that have been registered by the framework"
     * (https://laravel.com/docs/5.6/providers)
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrations();
        $this->loadTranslations();

        $this->registerPolicies();
    }

    /**
     * Load this package's routes
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    /**
     * Load this package's migrations.
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Load this package's translations
     *
     * @return void
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../translations/', 'lasallesoftwarecontactformbackend');
    }
}
