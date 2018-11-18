<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Agenda;
use DB;

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
            #$permissoes = (auth()->check())? User::findOrFail(Auth::id())->getPermissionsViaRoles()->pluck('name')->toArray(): '';
            $permissoes = '';
            $agenda = array();
            if(auth()->check()){
                $user = User::findOrFail(Auth::id());
                $timezone = $user->estado->timezone;
                date_default_timezone_set($timezone);
                $permissoes = $user->getPermissionsViaRoles()->pluck('name')->toArray();
                $agendamentos = Agenda::select(DB::raw('data as data_db'),DB::raw('count(*) as count'))
                                        ->where([
                                                    ['agenda_status_id','!=',2],
                                                    ['data','>',date("Y-m-d", strtotime("-6 months"))]
                                                ])
                                        ->groupBy('data')
                                        ->get();
                if($agendamentos != null){
                    foreach($agendamentos as $agendamento){
                        $agenda[$agendamento->data_db] = array('number' => $agendamento->count, 'badgeClass' => 'badge-warning');
                    }
                }
            }
            $view->with('permissoes',json_encode($permissoes));
            $view->with('agendamentos',json_encode($agenda));
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
