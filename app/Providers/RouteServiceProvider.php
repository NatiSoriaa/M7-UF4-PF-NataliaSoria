<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Defineix el namespace per als controladors.
     */
    protected $namespace = 'App\Http\Controllers';
    /**
     * Defineix el camí de la ruta HOME (opcional).
     */
    public const HOME = '/home';
    /**
     * Carrega les rutes del projecte.
     */
    public function boot()
    {
        parent::boot();
    }
    /**
     * Defineix les rutes de l'aplicació.
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }
    /**
     * Carrega les rutes API.
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));
    }
    /**
     * Carrega les rutes web.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
        ->group(base_path('routes/web.php'));
    }
}
