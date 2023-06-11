<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/site/include/const.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/site/include/dbconn.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/site/include/class.php";
ini_set("display_errors", 1);
error_reporting(E_ALL & ~E_NOTICE);

$SITE = new Main;
global $SITE;