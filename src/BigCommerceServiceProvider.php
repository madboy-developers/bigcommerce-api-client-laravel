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

        $this->app->scoped('bigcommerce-api', function () {
            return new BigCommerce();
        });

        $this->app->scoped('bigcommerce-client', function () {
            return new BigCommerceClient();
        });

        return $this;
    }
}