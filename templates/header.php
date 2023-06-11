<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>InformPr</title>
        <link href="<?= TEMPLATE_PATH ?>/style.css" rel="stylesheet" type="text/css" />
        <script
        src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
        crossorigin="anonymous"></script>
        <script src="<?= TEMPLATE_PATH ?>/js/forms.js"></script>
    </head>

    <body>
        <div id="header_panel">
            <div id="header_section">
                <div id="title_section">Справочник</div>
                <div id="tagline">по расходникам принтеров...</div>
            </div>
        </div> <!-- end of haeder -->
        <?php

        $SITE->IncludeComponent(
                'menu',
                'informpr_top',
                [
                    "MENU_TYPE" => "top",
                ]
        );
        ?>
        <div id="content">
            <div id="content_column_two">