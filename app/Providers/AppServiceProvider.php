<?php

namespace App\Providers;

use App\Models\Ingredient;
use App\Observers\IngredientObserver;
use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Usa i template di Bootstrap 5 per la paginazione
        Paginator::useBootstrapFive();
        
        // Registra il ViewComposer per la sidebar
        View::composer('layouts.sidebar', SidebarComposer::class);
        
        // Registra l'Observer per auto-rilevamento allergeni
        Ingredient::observe(IngredientObserver::class);
    }
}
