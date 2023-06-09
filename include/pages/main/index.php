<?php

$test = new Main;

/*
$test->IncludeComponent(
    'menu',
    'informpr_top',
    [
        'MENU_TYPE' => 'top',
    ]);
$_POST['menu-type'] = 'left';
*/
?>

<form method="post" action="<?= COMPONENTS_DIR ?>/menu/action.php">
    <input type="text" name="MENU_TYPE" required placeholder="Тип меню" />
    <table>
        <tr>
            <td>
                <input type="text" name="NAME" required placeholder="Название пункта" required/>
            </td>
            <td>
                <input type="text" name="URL" required placeholder="Ссылка" required/>
            </td>
            <td>
                <input type="text" name="CATEGORY" required placeholder="Категория" />
            </td>
            <td>
                <input type="text" name="DEPTH_LEVEL" placeholder="Вложенность (по умолчанию 1)" />
            </td>
            <td>
                <input type="text" name="PARENT_ID" placeholder="Родительский раздел" disabled/>
            </td>
        </tr>
    </table>
    <input type="submit" />
    <input type="hidden" name="ACTION" value="add" />
</form>