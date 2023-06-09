<?php if (!defined('INIT_INCLUDED')) exit; ?>
<ul>
    <?php foreach($arResult as $arItem): ?>
        <?php if ($arItem['CATEGORY'] != $arParams['CATEGORY']) continue; ?>
        <li><a class="btn" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
    <?php endforeach; ?>
</ul>
