<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}
?>

<div id="content_column_one">
    <?php foreach ($arResult['ITEMS'] as $arItem): ?>
        <div class="column_one_section">
            <h1><?= $arItem['ITEM']['NAME'] ?></h1>
            <ul>
                <?php foreach ($arItem['SUBITEMS'] as $subItem): ?>
                    <li><a class="btn" href="<?= $subItem['URL'] ?>"><?= $subItem['NAME'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php if (end ($arResult['ITEMS']) != $arItem): ?>
        <div class="cleaner_with_divider">&nbsp;</div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
