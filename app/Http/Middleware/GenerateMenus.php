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

            $menu->add('Administrador', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'menu-admin')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->administrador->add('Usuários', ['route'  => 'usuario.index'])
                    ->data('permission', 'usuario-listar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Perfis', ['route'  => 'roles.create'])
                    ->data('permission', 'perfil-listar')
                    ->link->attr(['class'=> 'dropdown-item']);

            /*$menu->add('Home', ['route'  => 'funcionario.create', 'class' => 'nav-item'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);*/
            $menu->add('About', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
                    /*$menu->about->add('Funcionário', ['route'  => 'funcionario.index'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->about->add('Funcionário criar', ['route'  => 'funcionario.create'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'dropdown-item']);*/
            /*$menu->add('Services', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'service'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
            $menu->add('Contact', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'contact'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);*/
            $menu->add('Roles', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->roles->add('Roles list', ['route'  => 'roles.index'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->roles->add('Roles create', ['route'  => 'roles.create'])
                    ->data('permission', 'product-list')
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
