<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/init/include/const.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/init/include/dbconn.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/init/include/class.php";
ini_set("display_errors", 1);
error_reporting(E_ALL & ~E_NOTICE);

$SITE = new Main;
global $SITE;