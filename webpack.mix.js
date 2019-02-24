let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');


mix.styles([
    /*'resources/assets/css/app/bootstrap.min.css', 
    'resources/assets/css/app/font-awesome.min.css', 
    'resources/assets/css/app/dashboard.css', 
    'resources/assets/css/app/style.css' 
    'resources/assets/css/app/custom.css'*/
    'resources/assets/css/app/font.css',
    'resources/assets/css/app/bootstrap.min.css',
    'resources/assets/css/app/bootstrap-datepicker.css',
    'resources/assets/css/app/jquery.timepicker.css',
    'resources/assets/css/app/style.css',
    'resources/assets/css/app/custom.css',
    'resources/assets/css/app/responsive-calendar.css'
], 'public/css/personalizado.css');

mix.scripts([
    'resources/assets/js/app/jquery.min.js',
    'resources/assets/js/app/jquery.blockUI.js',
    'resources/assets/js/app/popper.min.js',
    'resources/assets/js/app/bootstrap.min.js',
    'resources/assets/js/app/bootstrap-datepicker.js',
    'resources/assets/js/app/bootstrap-datepicker.pt-BR.js',
    'resources/assets/js/app/jquery.timepicker.min.js',
    'resources/assets/js/app/jquery.mask.min.js',
    'resources/assets/js/app/jquery.validate.min.js',
    'resources/assets/js/app/responsive-calendar.min.js',
    'resources/assets/js/app/jquery.shiftcheckbox.js',
    'resources/assets/js/app/notify.min.js',
    'resources/assets/js/app/moment-with-locales.js',
    //'resources/assets/js/app/pusher.min.js',
    'resources/assets/js/app/util.js',
    'resources/assets/js/app/base.js'
], 'public/js/personalizado.js');

// Agenda
mix.scripts([
    'resources/assets/js/agenda/index.js'
], 'public/js/agenda/index.js');
mix.scripts([
    'resources/assets/js/agenda/create.js'
], 'public/js/agenda/create.js');
mix.scripts([
    'resources/assets/js/agenda/edit.js'
], 'public/js/agenda/edit.js');

// Agenda Config
mix.scripts([
    'resources/assets/js/agenda_config/create.js'
], 'public/js/agenda_config/create.js');

// Atendimento
mix.scripts([
    'resources/assets/js/atendimento/index.js'
], 'public/js/atendimento/index.js');
mix.scripts([
    'resources/assets/js/atendimento/create.js'
], 'public/js/atendimento/create.js');
mix.scripts([
    'resources/assets/js/atendimento/edit.js'
], 'public/js/atendimento/edit.js');

// Paciente
mix.scripts([
    'resources/assets/js/paciente/index.js'
], 'public/js/paciente/index.js');
mix.scripts([
    'resources/assets/js/paciente/create.js'
], 'public/js/paciente/create.js');

// Relatório
mix.scripts([
    'resources/assets/js/relatorio/index.js'
], 'public/js/relatorio/index.js');
mix.scripts([
    'resources/assets/js/relatorio/create.js'
], 'public/js/relatorio/create.js');
mix.scripts([
    'resources/assets/js/relatorio/show.js'
], 'public/js/relatorio/show.js');
mix.scripts([
    'resources/assets/js/relatorio/gerenciar.js'
], 'public/js/relatorio/gerenciar.js');

// Relatório Categoria
mix.scripts([
    'resources/assets/js/relatorio_categoria/index.js'
], 'public/js/relatorio_categoria/index.js');
mix.scripts([
    'resources/assets/js/relatorio_categoria/create.js'
], 'public/js/relatorio_categoria/create.js');

// Role
mix.scripts([
    'resources/assets/js/role/index.js'
], 'public/js/role/index.js');
mix.scripts([
    'resources/assets/js/role/create.js'
], 'public/js/role/create.js');

// Sms
mix.scripts([
    'resources/assets/js/sms/pendentes.js'
], 'public/js/sms/pendentes.js');
mix.scripts([
    'resources/assets/js/sms/resposta.js'
], 'public/js/sms/resposta.js');

// Role
mix.scripts([
    'resources/assets/js/unidade/index.js'
], 'public/js/unidade/index.js');
mix.scripts([
    'resources/assets/js/unidade/create.js'
], 'public/js/unidade/create.js');

// User
mix.scripts([
    'resources/assets/js/user/index.js'
], 'public/js/user/index.js');
mix.scripts([
    'resources/assets/js/user/create.js'
], 'public/js/user/create.js');
mix.scripts([
    'resources/assets/js/user/edit.js'
], 'public/js/user/edit.js');