<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['log/(\d{4})-(\d{2})-(\d{2})'] = 'log/$1-$2-$3';
$route['log'] = 'log';

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
