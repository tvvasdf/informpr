<?php

include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';
include $_SERVER['DOCUMENT_ROOT'].'/page-parts/print-cart.php';

$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');


//Авторизация Cookie
$nickname=$_COOKIE['inputlogin'];
    $authorizedbool=false;
if ($_COOKIE["inputlogin"]<>""){

    $query_inputpass_cookie = mysqli_fetch_array(mysqli_query($link, "SELECT Password_hash FROM Users WHERE Nickname = '".$_COOKIE["inputlogin"]."'"));
    
    $query_nickname_cookie = mysqli_query($link,"SELECT Nickname FROM Users WHERE Nickname = '".$_COOKIE["inputlogin"]."'");
    
    if ($query_nickname_cookie){
    
    if ($query_inputpass_cookie[0]==$_COOKIE["inputpass"]){}
    }
    }

$nickname_db=mysqli_fetch_array(mysqli_query($link, "SELECT Nickname FROM Users WHERE Nickname = '".$nickname."'"))[0];
$rating_db=mysqli_fetch_array(mysqli_query($link, "SELECT Rating FROM Users WHERE Nickname = '".$nickname."'"))[0];

if ($link){
$profilecookie=mysqli_fetch_array(mysqli_query($link, "SELECT Password_hash FROM Users WHERE Nickname = '".$nickname."'"));
if ((trim($profilecookie[0])==$_COOKIE["inputpass"])&&($nickname<>"")){
$authorizedbool=true;
}
}
if ((!$authorizedbool) or ($rating_db<2)){header("Location: /login");}

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>'.
$tag_head
.'</head>';

echo ' 
<body>
'. 
$tag_body_header_menu.

'
<div id="content">

	'.
    $tag_body_content_column_one;

echo ' 

<div id="content_column_two">
    
    	<div class="column_two_section post_div">
<h1>Править запись</h1>
<div style="display: flex;">
<form method=POST style="margin: 10px;">
<p>Поиск по: </p>
<p><input name="id" pattern="[0-9]{1,8}" type=text value="" placeholder="ID"></input></p>
<p><input name="p" type=text value="" placeholder="Модель картриджа/принтера"></input></p>
<p><input name="q" type=checkbox value="all">Найти все записи</input></p>
<p><input type=submit class="btn"> </p>
</form>

<form method=POST style="margin: 10px;">
<p>Править запись по ID: </p>
<p><input name="edit" pattern="[0-9]{1,8}" type=text value="" placeholder="ID" required></input></p>
<p><input type=submit class="btn"> </p>
</form>
</div>

        </div>'

;

$posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `Model` LIKE "Sony%"');


if (($_POST["p"]!='')){
    $findtext=mysqli_real_escape_string($link, $_POST["p"]);
    $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `printers` LIKE "%'.$findtext.'%" OR `model` LIKE "%'.$findtext.'%"');
    if (mysqli_num_rows($posts)==0){
        echo '<div class="column_two_section post_div">
        По Вашему запросу '.$findtext.' ничего не найдено.
        </div>';
    }
    print_cartridges($posts, 1);
}
if (($_POST["id"]!='')){
        $findtext=mysqli_real_escape_string($link, $_POST["id"]);
        $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `idpost` = '.$findtext);
        if (mysqli_num_rows($posts)==0){
            echo '<div class="column_two_section post_div">
            По Вашему запросу ID='.$findtext.' ничего не найдено.
            </div>';
           
    }
    print_cartridges($posts, 1);
}

if (($_POST["q"]=='all')){
        $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` ORDER BY `date` DESC');
        print_cartridges($posts, 1);
}

if (($_POST["edit"]!='')){

    $findtext=mysqli_real_escape_string($link, $_POST["edit"]);
    $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `idpost` = '.$findtext);
    if (mysqli_num_rows($posts)==0){
        echo '<div class="column_two_section post_div">
        По Вашему запросу ID='.$findtext.' ничего не найдено.
        </div>';
       
} else {

$post=mysqli_fetch_array($posts);


    echo '<form method=POST>
    <div class="column_two_section post_div" id="third-div">
    <h1>Править информацию: </h1>
    <table>
    <tr>
    <td><p>Модель:</p></td>
    <td><p><input type="text" name="model" value="'.$post['model'].'" required disabled></input></p></td>
    </tr>
    <tr>
    <td><p>Вид картриджа(струйный и т.п.):</p></td>
    <td><p><input type="text" name="carttype" value="'.$post['carttype'].'"></input> Только для оригинальных</p></td>
    </tr>
    <tr>
    <td><p>Ресурс:</p></td>
    <td><p><input type="text" name="res" value="'.$post['res'].'" required></input></p></td>
    </tr>
    <tr>
    <td><p>Цвет:</p></td>
    <td>
    <p><input type="radio" name="color" value="Голубой" ';if($post['color']=='Голубой'){echo 'checked';} echo' required>Голубой</input></p>
    <p><input type="radio" name="color" value="Пурпурный" ';if($post['color']=='Пурпурный'){echo 'checked';} echo' required>Пурпурный</input></p>
    <p><input type="radio" name="color" value="Жёлтый" ';if($post['color']=='Жёлтый'){echo 'checked';} echo' required>Жёлтый</input></p>
    <p><input type="radio" name="color" value="Чёрный" ';if($post['color']=='Чёрный'){echo 'checked';} echo' required>Чёрный</input></p>
    </td>
    </tr>
    <tr>
    <td><p>Совместимость:</p></td>
    <td><p><textarea required name="printers">'.$post['printers'].'</textarea></p></td>
    </tr>
    </table>
    </div>

    <div class="column_two_section post_div">      
    <h1>Тип картриджа: </h1>
    <input type="text" name="type" value="'.$post['type'].'" disabled></input>

    <p><input class="btn" type="submit"></input></p>
    </form>
    </div>
    </table>
    ';
    
    
    $date_today=date("d.m.y G:i");
    
    //$posts=mysqli_query($link, 'DELETE FROM `Cartridges` WHERE `idpost` = '.$findtext);

    /*if (!$posts){echo '<div class="column_two_section post_div"> 
        Не удалось найти запись с ID='.$findtext.
        '</div>';} 
        
    else {echo '<div class="column_two_section post_div">
        Запись с ID='.$findtext.' удалена.
        </div>';}*/
}
}

if (($_POST["carttype"]!='')&&($_POST["res"]!='')&&($_POST["color"]!='')&&($_POST["printers"]!='')){
    if(mysqli_query($link, "UPDATE `Cartridges` SET `carttype`='".mysqli_real_escape_string($link, $_POST["carttype"])."', `res`='".mysqli_real_escape_string($link, $_POST["res"])."', `color`='".mysqli_real_escape_string($link, $_POST["color"])."', `date`='".$date_today."', `author`='".$nickname_db."', `printers`='".mysqli_real_escape_string($link, $_POST["printers"])."' WHERE `idpost`=".$findtext)){}
    else {echo 'Ошибка: '.mysqli_error($link);}
} else {echo 'Ошибка!!!: ';}

echo '</div> <!-- end of column two -->

<div class="cleaner">&nbsp;</div>

</div> <!-- end of content -->';

echo ' 
<div id="bottom_panel">'.
$tag_body_bottom_panel.
	
'</div> <!-- end of bottom panel -->

</body>
</html>'

?>