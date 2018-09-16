<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {#echo \Request::url();exit();
        \Menu::make('MenuTopo', function ($menu) {
            $menu->add('Agenda', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'menu-agenda')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->agenda->add('Secretária', ''/*['route'  => 'usuario.index']*/)
                    ->data('permission', 'agenda-secretaria')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->agenda->add('Médico', ''/*['route'  => 'roles.create']*/)
                    ->data('permission', 'agenda-medico')
                    ->link->attr(['class'=> 'dropdown-item']);

            $menu->add('Pacientes', ['route'  => 'paciente.index', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'paciente-listar')
                    ->link->attr(['class'=> 'nav-link']);

            $menu->add('Administrador', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'menu-admin')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->administrador->add('Usuários', ['route'  => 'usuario.index'])
                    ->data('permission', 'usuario-listar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Perfis', ['route'  => 'roles.index'])
                    ->data('permission', 'perfil-listar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Agenda config', ['route'  => 'agendaconfig.create'])
                    ->data('permission', 'perfil-listar')
                    ->link->attr(['class'=> 'dropdown-item']);

        })->filter(function($item){
            if(Auth::check()){
                if(User::find(Auth::id())->can( $item->data('permission'))) {
                    return true;
                }
            }
            return false;
          });
        return $next($request);
    }
}
