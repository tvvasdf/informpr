<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}
?>

<div id="menu_panel">
    <div id="menu_section">
        <ul>
            <?php foreach ($arResult as $arItem): ?>
                <li><a class="knopkaglav" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div> <!-- end of menu -->
