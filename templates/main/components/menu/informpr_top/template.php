<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}
?>

<div id="menu_panel">
    <div id="menu_section">
        <ul>
            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                <?php if ($arItem != end($arResult['ITEMS'])): ?>
                    <li><a class="knopkaglav" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
                <?php else: ?>
                    <li><a class="knopkaglav last" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div> <!-- end of menu -->
