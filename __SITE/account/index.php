<?php

include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';
    $nickname=$_COOKIE['inputlogin'];
    $authorizedbool=false;

$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');


//Авторизация Cookie

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
if (!$authorizedbool){header("Location: ../login");}




echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>'. 
$tag_head
.'
</head>
<body>'.
$tag_body_header_menu
.'
<div id="content"> 
'.$tag_body_content_column_one;
echo '<div id="content_column_two">';

if ($authorizedbool){
    include $_SERVER['DOCUMENT_ROOT'].'/account/profile'; //function print_profile($rating, $nickname)
    print_profile($rating_db, $nickname_db);

 echo '  
    </div> <!-- end of column two -->
     ';}
    echo '
    <div class="cleaner">&nbsp;</div>
</div> <!-- end of content -->

'.$tag_body_bottom_panel.'

    <div class="cleaner">&nbsp;</div>
</div> <!-- end of bottom panel -->
<!--  Free CSS Template by TemplateMo.com  -->
</body>
</html> ';
?>