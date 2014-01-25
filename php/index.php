<?php
ini_set('display_errors',1); 
error_reporting(E_ALL | E_STRICT);

require_once('libs/limonade.php');//Include the mvc limonade framework
//require_once('config/config.php');//Include Configuration file


/*Including Controllers and Models*/
require_once('controllers/controller.php');
require_once('models/model.php');

function before()
{
	set('title','QuickShop');
	layout('layout.php');//default layout
}

function not_found()
{
	set('title','QuickShop');
	layout('layout.php');
	return html("not_found.php");
}

/*Routes: */

dispatch('/','home');

run();
