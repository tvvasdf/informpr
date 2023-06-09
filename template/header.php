<?php if (!defined('INIT_INCLUDED')) exit; ?>

<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><? $SITE->ShowTitle(); ?></title>
        <link href="/template/style.css" rel="stylesheet" type="text/css" />
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
            <div id="content_column_one">
                <div class="column_one_section">
                    <h1>Расходники оригинальные</h1>
                    <?php

                    $SITE->IncludeComponent(
                        "menu",
                        "informpr_left",
                        [
                            "MENU_TYPE" => "left",
                            "CATEGORY" => "ORIGINAL",
                        ]
                    );
                    ?>
                </div>
                <div class="cleaner_with_divider">&nbsp;</div>
                <div class="column_one_section">
                    <h1>Совместимые расходники</h1>
                    <?php

                    $SITE->IncludeComponent(
                        "menu",
                        "informpr_left",
                        [
                            "MENU_TYPE" => "left",
                            "CATEGORY" => "COMPATIBLE",
                        ]
                    );
                    ?>
                </div>
                <div class="cleaner_with_divider">&nbsp;</div>
                <div class="column_one_section">
                    <h1>Наборы заправочные</h1>
                    <?php

                    $SITE->IncludeComponent(
                        "menu",
                        "informpr_left",
                        [
                            "MENU_TYPE" => "left",
                            "CATEGORY" => "REFUELING",
                        ]
                    );
                    ?>
                </div>


            </div> <!-- end of column one -->
            <div id="content_column_two">
