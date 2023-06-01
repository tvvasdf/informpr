<?php

$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');


include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';
include $_SERVER['DOCUMENT_ROOT'].'/page-parts/print-cart.php';


echo ' 
<body>
'. 
$tag_body_header_menu.

'
<div id="content">

	'.
    $tag_body_content_column_one;
    ?>

<div id="content_column_two">
