<?php

$templateName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/config/template.txt");
$systemName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/config/system.txt");

if (!$templateName) {
    $templateName = "default";
}

if (!$systemName) {
    $systemName = "site";
}

define ("SITE_DIR", $_SERVER['DOCUMENT_ROOT']);
define ("COMPONENTS_PATH", "/" . SITE_SYSTEM_NAME . "/components");

define ("INIT_INCLUDED", true);
define ("SITE_SYSTEM_NAME", "site");

define ("TEMPLATE_NAME", $templateName);
define ("TEMPLATE_DIR", $_SERVER['DOCUMENT_ROOT'] . "/templates/" . TEMPLATE_NAME);
define ("TEMPLATE_PATH", "/templates/" . TEMPLATE_NAME);

define ("CUSTOM_COMPONENTS_DIR", "/templates/" . TEMPLATE_NAME . "/components");

