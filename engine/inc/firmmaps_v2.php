<?php

if (!defined('DATALIFEENGINE') || !defined('LOGGED_IN')) {
	die('Hacking attempt!');
}

define('MODULE_DIR', ENGINE_DIR . '/modules/firmmaps_v2');
define('MODULE_URL', 'engine/modules/firmmaps_v2');

echoheader("<h4><i class=\"fa fa-cogs position-left\"></i><span class=\"text-semibold\">Карта компаний</span></h4>", 
"Настройка параметров карты компаний (используйте навигацию для доступа к разделам)");


include MODULE_DIR . '/admin/main.php';

include MODULE_DIR . '/admin/footer.php';

echofooter();

