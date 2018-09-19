<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){ // Pega as permissões do usuário a cada requisição de página
            $permissoes = (auth()->check())? User::findOrFail(Auth::id())->getPermissionsViaRoles()->pluck('name')->toArray(): '';
            $view->with('permissoes',json_encode($permissoes));
        });
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
