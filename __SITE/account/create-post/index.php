<?php

include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/images/cart/';
$uploadfile = $uploaddir . basename($_FILES['cartpic']['name']);


$nickname=$_COOKIE['inputlogin'];
    $authorizedbool=false;

$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');



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
if ((!$authorizedbool) or ($rating_db<4)){header("Location: /login");}



echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>'. 
$tag_head
.' 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>'.
$tag_body_header_menu.'
<div id="content">
'.$tag_body_content_column_one;

echo ' 

<div id="content_column_two">';


        echo '
        <form method=POST enctype="multipart/form-data">
        <div class="column_two_section post_div" id="third-div">
        <h1>Введите информацию: </h1>
        <table>
        <tr>
        <td><p>Модель:</p></td>
        <td><p><input type="text" name="model" placeholder="Canon PG-46" required></input></p></td>
        </tr>
        <tr>
        <td style="display: flex;"><p>Вид картриджа(струйный и т.п.):</p></td>
        <td><p><input type="text" name="carttype" placeholder="Струйный"></input> Если неориг., указать бренды, с принтерами которых совместим. <br>Например: <b>Canon, Epson </b></p></td>
        </tr>
        <tr>
        <td><p>Ресурс:</p></td>
        <td><p><input type="radio" name="res-radio" value="" checked>Стандартный</input><input style="margin-left: 1.85em;" type="text" name="res" required placeholder="400"></input> страниц формата А4 при 5% заполнении страницы. </p>
        <p><input type="radio" name="res-radio" id="res-other" value="Другой">Другой</input><input style="margin-left: 5em;" type="text" name="res-other-text" required placeholder="7 метров" disabled></input> </p></td>
        </tr>


        <tr>
        <td><p>Совместимость:</p></td>
        <td><p><textarea required name="printers" placeholder="Canon PIXMA E464 Canon PIXMA E414 "></textarea></p></td>
        </tr>

        <tr>
        <td><p>Цвет:</p></td>
        <td>

        <p><input type="radio" name="color" value="Голубой" required>Голубой</input></p>
        <p><input type="radio" name="color" value="Пурпурный" required>Пурпурный</input></p>
        <p><input type="radio" name="color" value="Жёлтый" required>Жёлтый</input></p>
        <p><input type="radio" name="color" value="Чёрный" required>Чёрный</input></p>
        <p><input type="radio" name="color" value="Цветной" required>Цветной (содержит все цвета)</input></p>
        <p><input type="radio" name="color" id="radio-other" value="Другой"> Другой</input><input style="margin-left: 5em;" type="text" name="color-text" id="color-text" required disabled placeholder="Светло-серый"></input></p>
        </td>

        </tr>

        

        </table>
        </div>

        <div class="column_two_section post_div">  
        <h1>Загрузите картинку картриджа: </h1>
        <input name="cartpic" required type="file" accept="image/jpeg,image/png" />
        (поддерживаемые форматы: jpg, png. Размер не больше 2МБ)
        </div>

        <div class="column_two_section post_div">      
        <h1>Выберите тип картриджа: </h1>
        <table style="border-spacing: 50px 0px; margin:auto;">
        <tr>
        <th><p>Оригинальные картриджи</p></th>
        <th><p>Совместимые картриджи</p></th>
        <th><p>Заправочные наборы</p></th>
        </tr>
        <tr>
        <td><p><input type="radio" name="type" value="original" required>Оригинальные </input></p></td>
        <td><p><input type="radio" name="type" value="comp-laser" required> Лазерные </input></p></td>
        <td><p><input type="radio" name="type" value="ref-laser" required> Лазерные </input></p></td>
        </tr>
        <tr>
        <td></td>
        <td><p><input type="radio" name="type" value="comp-matrix" required> Матричные </input></p></td>
        <td><p><input type="radio" name="type" value="ref-jet" required> Струйные </input></p></td>
        </tr>
        <tr>
        <td></td>
        <td><p><input type="radio" name="type" value="comp-jet" required> Струйные </input></p></td>
        </tr>
        <tr>
        <td></td>
        <td><p><input type="radio" name="type" value="comp-stickers" required> Ленты для печати наклеек </input></p></td>
        </tr>
        <tr>
        <td></td>
        <td><p><input type="radio" name="type" value="comp-fax" required> Плёнка для факса </input></p></td>
        </tr>

        </table>
        
        <p><input class="btn" type="submit"></input></p>
        </form>
        </div>
        </table>
        ';



    $idcheckbool=false;
        while (!$idcheckbool){
            $idpost=rand(0,99999999);
            $idcheck=mysqli_num_rows(mysqli_query($link,'SELECT * FROM `Cartridges` WHERE `idpost`="'.$idpost.'"'));
            if ($idcheck==0){$idcheckbool=true;}
        }

        
        if (in_array($_FILES['cartpic']['type'], array('image/jpeg','image/png'))){

            if ($_FILES['cartpic']['size'] <= 2097152) {
            
            if (move_uploaded_file($_FILES['cartpic']['tmp_name'], $uploaddir . $idpost . '.jpg')) {
             $file_loaded=true;
            
            

            /*
            $fmas = scandir($uploaddir);
            echo '<meta http-equiv="refresh" content="1;URL=/account/create-post" />';
            echo "<script type='text/javascript'>alert('Файл успешно загружен');</script>";

            echo 'Некоторая отладочная информация:\n';
            print_r($_FILES);
            print_r($fmas);
            echo $uploaddir . $_FILES['cartpic']['name'], $uploaddir . strval(count($fmas)) . '.' . str_replace('image/','',$_FILES['cartpic']['type']);
            */
            }
            
            else 
            {
            //echo '<meta http-equiv="refresh" content="1;URL=/account/create-post" />';
            echo "<script type='text/javascript'>alert('Возможная атака с помощью файловой загрузки!');</script>";
            }
            
            }
            }
            
            if ((!in_array($_FILES['cartpic']['type'], array('image/jpeg','image/png')) and ($_FILES['cartpic']['size'] > 0)) || $_FILES['cartpic']['size'] > 2097152)
            { 
            //echo '<meta http-equiv="refresh" content="1;URL=/account/create-post" />';
            echo "<script type='text/javascript'>alert('Загруженный файл имеет другой формат или размер файла больше допустимого');</script>";
            print_r ($_FILES);
            echo ($_FILES['cartpic']['size']);
            
            }

        $date_today=date("d.m.y G:i");
        $dublicate=mysqli_fetch_array(mysqli_query($link,'SELECT COUNT(*) FROM `Cartridges` WHERE `model`="'.$_POST["model"].'"'));
if (($_POST["type"]!='')&&($_POST["model"]!='')&&($_POST["carttype"]!='')&&(($_POST["res"]!='') or ($_POST["res-radio"]!=''))&&($_POST["color"]!='')&&($_POST["printers"]!='')&&($file_loaded)){
    if($dublicate[0]==0){

        if (($_POST["color"]=='Другой') and ($_POST["res-radio"]=='Другой')){
                if(mysqli_query($link, 'INSERT INTO `Cartridges`(`type`, `model`, `carttype`, `res`, `color`, `date`, `author`, `idpost`, `printers`) VALUES ("'.mysqli_real_escape_string($link, $_POST["type"]).'","'.mysqli_real_escape_string($link, $_POST["model"]).'","'.mysqli_real_escape_string($link, $_POST["carttype"]).'","'."[othr]".mysqli_real_escape_string($link, $_POST["res-other-text"]).'","'.mysqli_real_escape_string($link, $_POST["color-text"]).'","'.$date_today.'","'.$nickname_db.'","'.$idpost.'","'.mysqli_real_escape_string($link, $_POST["printers"]).'")')){
                    echo "<script type='text/javascript'>alert('Запись с ID: ".$idpost." создана');</script>";}
                else { echo "<script type='text/javascript'>alert('Ошибка: ".mysqli_error($link)."');</script>";} 
            } 

        if(($_POST["color"]=='Другой') and ($_POST["res-radio"]!='Другой')){
            if(mysqli_query($link, 'INSERT INTO `Cartridges`(`type`, `model`, `carttype`, `res`, `color`, `date`, `author`, `idpost`, `printers`) VALUES ("'.mysqli_real_escape_string($link, $_POST["type"]).'","'.mysqli_real_escape_string($link, $_POST["model"]).'","'.mysqli_real_escape_string($link, $_POST["carttype"]).'","'.mysqli_real_escape_string($link, $_POST["res"]).'","'.mysqli_real_escape_string($link, $_POST["color-text"]).'","'.$date_today.'","'.$nickname_db.'","'.$idpost.'","'.mysqli_real_escape_string($link, $_POST["printers"]).'")')){
                echo "<script type='text/javascript'>alert('Запись с ID: ".$idpost." создана');</script>";}
                else { echo "<script type='text/javascript'>alert('Ошибка: ".mysqli_error($link)."');</script>";}
            }

        if(($_POST["color"]!='Другой') and ($_POST["res-radio"]=='Другой')){
            if(mysqli_query($link, 'INSERT INTO `Cartridges`(`type`, `model`, `carttype`, `res`, `color`, `date`, `author`, `idpost`, `printers`) VALUES ("'.mysqli_real_escape_string($link, $_POST["type"]).'","'.mysqli_real_escape_string($link, $_POST["model"]).'","'.mysqli_real_escape_string($link, $_POST["carttype"]).'","'."[othr]".mysqli_real_escape_string($link, $_POST["res-other-text"]).'","'.mysqli_real_escape_string($link, $_POST["color"]).'","'.$date_today.'","'.$nickname_db.'","'.$idpost.'","'.mysqli_real_escape_string($link, $_POST["printers"]).'")')){
                echo "<script type='text/javascript'>alert('Запись с ID: ".$idpost." создана');</script>";
            } else { echo "<script type='text/javascript'>alert('Ошибка: ".mysqli_error($link)."');</script>";}
                }

        if(($_POST["color"]!='Другой') and ($_POST["res-radio"]!='Другой')){
            if(mysqli_query($link, 'INSERT INTO `Cartridges`(`type`, `model`, `carttype`, `res`, `color`, `date`, `author`, `idpost`, `printers`) VALUES ("'.mysqli_real_escape_string($link, $_POST["type"]).'","'.mysqli_real_escape_string($link, $_POST["model"]).'","'.mysqli_real_escape_string($link, $_POST["carttype"]).'","'.mysqli_real_escape_string($link, $_POST["res"]).'","'.mysqli_real_escape_string($link, $_POST["color"]).'","'.$date_today.'","'.$nickname_db.'","'.$idpost.'","'.mysqli_real_escape_string($link, $_POST["printers"]).'")')){
                echo "<script type='text/javascript'>alert('Запись с ID: ".$idpost." создана');</script>";
            } else { echo "<script type='text/javascript'>alert('Ошибка: ".mysqli_error($link)."');</script>";}    
        }

    } else echo "<script type='text/javascript'>alert('Такая запись уже существует!');</script>";
    } 
    
    echo '</div> <!-- end of column two -->

    <div class="cleaner">&nbsp;</div>
    
</div> <!-- end of content -->';

echo "<script>
$('input[name=".'"color"'."]').change(function(){
    if ($('input[id=".'"radio-other"'."]').is(':checked')){
        $('input[id=color-text]').removeAttr('disabled' );
    } else {
        $('input[id=color-text]').attr('disabled','' );
    }
});
</script>";

echo "<script>
$('input[name=".'"res-radio"'."]').change(function(){
    if ($('input[id=".'"res-other"'."]').is(':checked')){
        $('input[name=res-other-text]').removeAttr('disabled' );
        $('input[name=res]').attr('disabled','' );
    } else {
        $('input[name=res]').removeAttr('disabled' );
        $('input[name=res-other-text]').attr('disabled','' );
    }
});
</script>";

echo ' 
<div id="bottom_panel">'.
$tag_body_bottom_panel.
	
'</div> <!-- end of bottom panel -->

</body>
</html>'

?>