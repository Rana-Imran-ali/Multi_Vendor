<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\PaymentGatewayInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\VendorRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\VendorRepository;
use App\Services\Payment\MockPaymentGateway;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register Repository & Interface bindings.
     * All controllers that inject an interface will receive the implementation.
     */
    public function register(): void
    {
        // Core Repository Bindings
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        // Payment Gateway — swap MockPaymentGateway for StripePaymentGateway in production
        $this->app->bind(PaymentGatewayInterface::class, MockPaymentGateway::class);
    }

    public function boot(): void
    {
        //
    }
}
