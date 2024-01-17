<?php

namespace App\Providers;

use App\Repositories\Interfaces\NoteInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\NoteRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        UserInterface::class => UserRepository::class,
        NoteInterface::class => NoteRepository::class
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
