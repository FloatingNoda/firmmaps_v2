<?php
@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

define( 'DATALIFEENGINE', true );
define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -39 ) );
define( 'ENGINE_DIR', ROOT_DIR."/engine" );

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


$tpl->load_template ( 'showall.tpl' );
$table = PREFIX."_firmmaps_catalog";  // название таблицы
$fields  = 'COUNT(*)'; // нужные поля, * - все поля
$where="1=1";
$multirow = 1; // забирать ли один ряд или несколько
$start = 0; // начальное значение выборки
$limit = 0; // количество записей для выборки, 0 - выбрать все
$m = $dle_api->load_table ($table,$fields,$where,$multirow,$start,$limit);
$count=$m[0]['COUNT(*)'];
$curpage=$_GET['list'];
if ($_GET['show_by']==0) $tpl->set ( '{list}', "");
else{
	$listCount=intdiv($count,$_GET['show_by']);
	if ($count%$_GET['show_by']>0) $listCount++;
	for ($i=1;$i<=$listCount;$i++){
		if ($i==$curpage) $temp.="<b>[$i]</b>";
		else $temp.="<a onclick='listchange($i)'>[$i]</a>";
	}
	$tpl->set ( '{list}', $temp);
}

$table = PREFIX."_firmmaps_catalog AS cat LEFT JOIN ".PREFIX."_firmmaps_region AS reg ON (reg.id=cat.region) LEFT JOIN ".PREFIX."_firmmaps_city AS city ON (city.id=cat.city)";  // название таблицы
$fields  = 'cat.*, reg.name AS name_region, city.name AS name_city'; // нужные поля, * - все поля
$where="1=1";
$multirow = 1; // забирать ли один ряд или несколько
$start = ($curpage-1)* $_GET['show_by']; // начальное значение выборки
$limit = $_GET['show_by']; // количество записей для выборки, 0 - выбрать все

$m = $dle_api->load_table ($table,$fields,$where,$multirow,$start,$limit);

$i=0;
$temp="";	

foreach($m as $data){
	$i++;
	
	$temp.="<tr>";
	$temp.="<th scope='row'>".$data['id']."</th>";
	$temp.="<td>".$data['name']."</td>";
	$temp.="<td>".$data['name_region']."</td>";
	$temp.="<td>".$data['name_city']."</td>";
	$temp.="<th>".$data['stars']."</th>";
	$temp.="<td>".gmdate("Y-m-d H:i:s", $data['createNote'])."</td>";
	$temp.="<td>".gmdate("Y-m-d H:i:s", $data['changeNote'])."</td>";
	$temp.="<td><a href='javascript:edit(".$data['id'].");'><i class='fa fa-pencil' style='font-size: 30px;color:green;'></i></a><a href='javascript:del(".$data['id'].");'><i class='fa fa-remove' style='font-size: 30px;color: red;'></i></a></td>";
	$temp.="</tr>";
}
$tpl->set ( '{table_data}', $temp);
$tpl->compile ( 'showall' );
echo $tpl->result['showall'];
$tpl->global_clear();