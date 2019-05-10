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
            $menu->add('Agenda', ['route'  => 'agenda.index', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'agenda-menu')
                    ->link->attr(['class'=> 'nav-link']);
                    /*$menu->agenda->add('Secretária', '')
                    ->data('permission', 'agenda-secretaria')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->agenda->add('Médico', '')
                    ->data('permission', 'agenda-medico')
                    ->link->attr(['class'=> 'dropdown-item']);*/

            /*$menu->add('SMS', ['route'  => 'sms.pendentes', 'class' => 'nav-item dropdown'])
            ->data('permission', 'menu-agenda')
            ->link->attr(['class'=> 'nav-link']);*/

            $menu->add('Sms', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'sms-gerenciar')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->sms->add('Confirmar consultas', ['route'  => 'sms.pendentes'])
                    ->data('permission', 'sms-gerenciar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->sms->add('Obter respostas', ['route'  => 'sms.resposta'])
                    ->data('permission', 'sms-gerenciar')
                    ->link->attr(['class'=> 'dropdown-item']);

            $menu->add('Pacientes', ['route'  => 'paciente.index', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'paciente-listar')
                    ->link->attr(['class'=> 'nav-link']);

            $menu->add('Relatórios', ['url'  => '#', 'class' => 'nav-item dropdown'])
                ->data('permission', 'relatorio-menu')
                ->link->attr(['class'=> 'nav-link']);
                $menu->relatorios->add('Visualizar', ['route'  => 'relatorios.index'])
                ->data('permission', 'relatorio-visualizar')
                ->link->attr(['class'=> 'dropdown-item']);
                $menu->relatorios->add('Categorias', ['route'  => 'relatorioCategoria.index'])
                ->data('permission', 'relatorio_categoria-gerenciar')
                ->link->attr(['class'=> 'dropdown-item']);
                $menu->relatorios->add('Gerenciar', ['route'  => 'relatorio.gerenciar'])
                ->data('permission', 'relatorio-gerenciar')
                ->link->attr(['class'=> 'dropdown-item']);

            $menu->add('Administrador', ['url'  => '#', 'class' => 'nav-item dropdown'])
                    ->data('permission', 'admin-menu')
                    ->link->attr(['class'=> 'nav-link']);
                    $menu->administrador->add('Clínica / Consultório', ['route'  => 'unidade.index'])
                    ->data('permission', 'unidade-gerenciar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Perfis', ['route'  => 'roles.index'])
                    ->data('permission', 'perfil-listar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Usuários', ['route'  => 'usuario.index'])
                    ->data('permission', 'usuario-listar')
                    ->link->attr(['class'=> 'dropdown-item']);
                    $menu->administrador->add('Agenda config', ['route'  => 'agendaconfig.create'])
                    ->data('permission', 'agenda_config-gerenciar')
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
