<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.50.103',
	'username' => 'root',
	'password' => 'jack5899',
	'database' => 'moodle',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => FALSE
);

$db['phy'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.50.103',
	'username' => 'root',
	'password' => 'jack5899',
	'database' => 'training',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => FALSE
);

$db['dcsdphy'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.50.103',
	'username' => 'root',
	'password' => 'jack5899',
	'database' => 'course',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => FALSE
);

// $connect_info = "(DESCRIPTION =
// 				(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.0.48)(PORT = 1521)))
// 				(CONNECT_DATA =(SID = elPhyDB))
// 				)";

// $db['phy'] = array(
// 	'dsn'	=> '',
// 	'hostname' => $connect_info,
// 	'username' => 'training',
// 	'password' => 'phDBaC205A',
// 	'database' => 'training',
// 	'dbdriver' => 'oci8',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => TRUE,
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => FALSE
// );
