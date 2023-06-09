<div id="menu_section">
    <ul>
        <?php foreach ($arResult as $key => $arItem): ?>
            <li><a class="knopkaglav <?php if (!next($arResult)): ?>last<?php endif; ?>" href="<?= $arItem['URL'] ?>"><?= $arItem['NAME'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
