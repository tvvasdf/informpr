<?php

include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';

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
if ((!$authorizedbool) or ($rating_db<3)){header("Location: /login");}

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
<h1>Пользователи</h1>


<form method=POST>
<p>Поиск по логину: </p>
<p><input name="n" type=text value="" placeholder="Логин"></input></p>
<p><input name="q" type=checkbox value="all">Найти все записи</input></p>
<p><input type=submit class="btn" style="margin: 0;"> </p>
</form>

        </div>'

;

function print_users($nickname, $rating){
    global $rating_db;
    echo '<div class="column_two_section post_div">';
    echo '<b><p>Логин: '.$nickname.'</p>';
    echo '<p>Права: </b>';

    switch ($rating){
        case 0: echo '<b>Обычного пользователя (0)</p></b>';
        echo '<form method=post><p><input type=radio value="moder" name="manage" required>Назначить модератором (1)</input></p>';
        if ($rating_db==5){echo '<p><input type=radio value="admin" name="manage" required>Назначить администратором (2)</input></p>';};
        echo '<p><input type=checkbox value="'.$nickname.'" name="nick" required>Назначить '.$nickname.'</input></p>';
        echo '<p><input type=submit class="btn" style="margin: 0;"></p></form>';
        break;
        
        case 1: echo '<b>Модератора (1)</b>';
        echo '<form method=post><p><input type=radio value="user" name="manage" required>Разжаловать (0)</input></p>';
        if ($rating_db==5){echo '<p><input type=radio value="admin" name="manage" required>Назначить администратором (2)</input></p>';};
        echo '<p><input type=checkbox value="'.$nickname.'" name="nick" required>Назначить '.$nickname.'</input></p>';
        echo '<p><input type=submit class="btn" style="margin: 0;"></p></form>';
        break;
        
        case 2: echo '<b>Администратора (2)</b>';
        if ($rating_db==5){echo '<form method=post><p><input type=radio value="moder" name="manage" required>Назначить модератором (1)</input></p>';
        echo '<p><input type=radio value="user" name="manage" required>Разжаловать (0)</input></p>';
        echo '<p><input type=checkbox value="'.$nickname.'" name="nick" required>Назначить '.$nickname.'</input></p>';
        echo '<p><input type=submit class="btn" style="margin: 0;"></p></form>';}
        break;
        
        case 3: echo '<b>Главного администратора (3)</b>';
        break;
        
        case 4: echo '<b>Разработчика проекта (4)</b>';
        break;
        
        case 5: echo '<b>Главного разработчика проекта (5)</b>';
        break;
        
        default: echo '<b>Ошибка</b>';
        break;

        
        }
echo '<br></div>';
}

if (($_POST["n"]!='')){
    $findtext=mysqli_real_escape_string($link, $_POST["n"]);
    $users=mysqli_query($link, 'SELECT * FROM `Users` WHERE `Nickname`= "'.$findtext.'"');
    $row=mysqli_fetch_array($users);
    if (mysqli_num_rows($users)==0){
        echo '<div class="column_two_section post_div">
        По Вашему запросу '.$findtext.' ничего не найдено.
        </div>';
    } else {
    print_users($row['Nickname'],$row['Rating']);}
}


if ($_POST["q"]=='all'){
        $users=mysqli_query($link, 'SELECT * FROM `Users` ORDER BY `Rating` DESC');
        while($row=mysqli_fetch_array($users)){
            print_users($row['Nickname'],$row['Rating']);
            }
}



if (($_POST["manage"]!='') and ($_POST["nick"]!='')){
    switch ($_POST["manage"]){
    case "moder": 
    if (mysqli_query($link, 'UPDATE `Users` SET `Rating`=1 WHERE `Nickname`="'.mysqli_real_escape_string($link, $_POST["nick"]).'"')){echo '<div class="column_two_section post_div">
         '.$_POST["nick"].' назначен модератором.
        </div>';}
    break;

    case "admin": 
    if (mysqli_query($link, 'UPDATE `Users` SET `Rating`=2 WHERE `Nickname`="'.mysqli_real_escape_string($link, $_POST["nick"]).'"')){echo '<div class="column_two_section post_div">
        '.$_POST["nick"].' назначен администратором.
        </div>';}
    break;

    case "user": 
    if (mysqli_query($link, 'UPDATE `Users` SET `Rating`=0 WHERE `Nickname`="'.mysqli_real_escape_string($link, $_POST["nick"]).'"')){echo '<div class="column_two_section post_div">
        '.$_POST["nick"].' разжалован.
        </div>';}
    break;
    

    default: echo '<div class="column_two_section post_div">
        Ошибка: неверное значение в POST запросе
        </div>';
    break;

    }


}

/*
if ($_POST["debug"]=='clowniyparoldebug'){
    include $_SERVER['DOCUMENT_ROOT'].'/account/profile'; //function print_profile($rating)
    for ($rating_test = 0; $rating_test <= 5; $rating_test++) {
        print_profile($rating_test);
    }}
*/
    

echo '</div> <!-- end of column two -->

<div class="cleaner">&nbsp;</div>

</div> <!-- end of content -->';

echo ' 
<div id="bottom_panel">'.
$tag_body_bottom_panel.
	
'</div> <!-- end of bottom panel -->

</body>
</html>';

?>