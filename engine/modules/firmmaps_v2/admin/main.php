<?php
@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

define( 'DATALIFEENGINE', true );
define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -39 ) );
define( 'ENGINE_DIR', ROOT_DIR."/engine" );

if (!defined('DATALIFEENGINE') || !defined('LOGGED_IN')) {
    die('Hacking attempt!');
}

include_once ENGINE_DIR . '/classes/plugins.class.php';
require_once (DLEPlugins::Check(ENGINE_DIR . '/classes/templates.class.php'));
require_once (DLEPlugins::Check(ENGINE_DIR . '/classes/mysql.php'));
require_once (DLEPlugins::Check(ENGINE_DIR . '/inc/include/functions.inc.php'));
require_once (DLEPlugins::Check(ENGINE_DIR . '/data/dbconfig.php'));
require_once (DLEPlugins::Check(ENGINE_DIR .'/api/api.class.php'));

$tpl = new dle_template( );
$tpl->dir = ROOT_DIR . '/engine/modules/firmmaps_v2/admin/pages/tpl/';
define( 'TEMPLATE_DIR', $tpl->dir );
//--------------------------------------------------------------------------

$tpl->load_template ( 'main.tpl' );
$tpl->compile ( 'main' );
echo $tpl->result['main'];
echo "<script src='".MODULE_URL."/admin/js/admin.js'></script>";
?>

