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
if ((!$authorizedbool) or ($rating_db<1)){header("Location: /login");}



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
<h1>Справка</h1>
Обычный пользователь (0) не имеет особых прав на сайте <br>
Модератор (1) может просматривать этот раздел, а также видеть ID, дату и авторов записей <br>
Администратор (2) может править записи <br>
Главный администратор (3) может назначать и убирать модераторов <br>
Разработчик проекта (4) может добавлять и удалять записи <br>
Главный разработчик проекта (5) может назначать и убирать администраторов 
        </div>'

;



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