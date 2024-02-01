<?php

namespace App\Providers;

use App\Repositories\Eloquent\GenerationRepository;
use App\Repositories\Eloquent\ModelRepository;
use App\Repositories\Interfaces\GenerationInterface;
use App\Repositories\Interfaces\ModelInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        ModelInterface::class => ModelRepository::class,
        GenerationInterface::class => GenerationRepository::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
