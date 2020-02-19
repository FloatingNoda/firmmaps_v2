<?php
@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

define( 'DATALIFEENGINE', true );
define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define( 'ENGINE_DIR', ROOT_DIR . '/engine' );

$mod = str_replace(chr(0), '', (string)$_REQUEST['mod']);
$mod = trim( strtolower(strip_tags( $mod )) );
$mod = preg_replace( "/\s+/ms", "_", $mod );
$mod = str_replace( "/", "_", $mod );
$mod = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $mod );

if( !$mod ) {
	
	header( "HTTP/1.1 403 Forbidden" );
	header ( 'Location: ../../' );
	die( "Hacking attempt!" );
	
}
?>


<div class="panel-body">
    Текст для editcity таба           
</div>
