<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Taipei');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will try guess the protocol, domain
| and path to your installation. However, you should always configure this
| explicitly and never rely on auto-guessing, especially in production
| environments.
|
*/
$config['base_url'] = '';
$httpRoot  = "http://".$_SERVER['HTTP_HOST'];
$httpRoot .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$httpRoot = rtrim($httpRoot, '/'); /** */
$config['base_url'] = $httpRoot;

$httpRoot  = "http://".$_SERVER['HTTP_HOST'];
$config['eda_apply_url'] = $httpRoot . "/apply";
