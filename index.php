<?php
date_default_timezone_set('America/La_Paz');
setlocale(LC_TIME, 'es_ES.UTF-8','esp');
setlocale(LC_TIME, 'spanish');

//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
error_reporting(E_ERROR);
ini_set('display_errors', true);
ini_set('html_errors', true);

define('DIR_SEPARATOR', DIRECTORY_SEPARATOR);
define('ROOT_APPLICATION', realpath(dirname(__FILE__)).DIR_SEPARATOR);
define('ROOT_ARCH_FRWRK_PATH', ROOT_APPLICATION.'idensystem'.DIR_SEPARATOR);

try
	{
		require_once ROOT_ARCH_FRWRK_PATH.'idenSetUp.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenRequest.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenInitialize.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenController.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenModel.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenView.php';
		require_once ROOT_ARCH_FRWRK_PATH.'idenHash.php';
		require_once ROOT_ARCH_FRWRK_PATH.'IdEnSession/idenSession.php';
		require_once ROOT_ARCH_FRWRK_PATH.'IdEnDataBase/idenDataBase.php';
	
		IdEnSession::iniSession();
		
		IdEnInitialize::Execute(new IdEnRequest);		
	}
catch(Exception $e)
	{
		echo $e->getMessage();
	}

?>