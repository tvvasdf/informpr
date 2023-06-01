<?
$link = mysqli_connect('localhost', 'root', '');
mysqli_select_db($link,'informpr');
$posts=mysqli_query($link,"SELECT * FROM `cartridges`");

?>

<table border=1px>
<tbody>
        <tr>
            <td>Автор</td>
            <td>Тип картриджа</td>
            <td>Цвет картриджа</td>
            <td>Дата создания</td>
            <td>ID</td>
            <td>Модель</td>
            <td>Ресурс</td>
            <td>Тип картриджа</td>
            <td>Поддерживаемые принтеры</td>

        </tr>
    <?while($row = mysqli_fetch_array($posts)):?>
        <tr>
            <td><?=$row['author']?></td>
            <td><?=$row['carttype']?></td>
            <td><?=$row['color']?></td>
            <td><?=$row['date']?></td>
            <td><?=$row['idpost']?></td>
            <td><?=$row['model']?></td>
            <td><?=$row['res']?></td>
            <td><?=$row['type']?></td>
            <td><?=$row['printers']?></td>
        </tr>
    <?endwhile;?>

</tbody>
</table>