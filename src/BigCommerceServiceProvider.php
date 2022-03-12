<?php

namespace MadBoy\BigCommerceAPI;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BigCommerceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('bigcommerce-api-laravel')
            ->hasConfigFile();
    }

    /**
     * @throws InvalidPackage
     */
    public function register()
    {
        parent::register();

        $this->app->bind('bigcommerce-helper', function () {
            return new BigCommerce();
        });

        $this->app->bind('bigcommerce-client', function () {
            return new BigCommerceClient();
        });

        return $this;
    }
}