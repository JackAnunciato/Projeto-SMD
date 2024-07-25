<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Rota Login
    $route['login'] = 'Login/autenticar';
    // Rotas para PessoaController
    $route['pessoa'] = 'PessoaController/index';
    $route['pessoa/(:num)'] = 'PessoaController/show/$1';
    $route['pessoa/criar'] = 'PessoaController/create';
    $route['pessoa/salvar'] = 'PessoaController/store';
    $route['pessoa/atualizar/(:num)'] = 'PessoaController/update/$1';
    $route['pessoa/deletar/(:num)'] = 'PessoaController/delete/$1';


