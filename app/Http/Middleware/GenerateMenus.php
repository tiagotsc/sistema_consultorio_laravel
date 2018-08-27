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
    {
        \Menu::make('MenuTopo', function ($menu) {
            $menu->add('Home', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'home'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
            $menu->add('About', ['route'  => 'roles.index', 'class' => 'nav-item dropdown', 'id' => 'about'])
            #->add('Level2', 'link address')
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->about->add('Funcionário', ['route'  => 'funcionario.index'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'dropdown-item']);
            /*$menu->add('Services', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'service'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
            $menu->add('Contact', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'contact'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);
            $menu->add('Roles', ['route'  => 'roles.index', 'class' => 'nav-item', 'id' => 'role'])
                    ->data('permission', 'product-list')
                    ->link->attr(['class'=> 'nav-link']);*/
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
