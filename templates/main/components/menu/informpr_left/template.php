<?php
if (!defined('INIT_INCLUDED')) {
    exit;
}
?>
<div id="content_column_one">
    <?php foreach ($arResult['CATEGORIES'] as $category): ?>
            <div class="column_one_section">
                <h1><?= $category['NAME'] ?></h1>
                <ul>
                    <?php foreach ($category['ITEMS'] as $arItem): ?>
                        <li><a class="btn" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
    <?php if($category != end($arResult['CATEGORIES'])): ?>
        <div class="cleaner_with_divider">&nbsp;</div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
