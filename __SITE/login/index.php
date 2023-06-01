<?php


// подключение к БД
include $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';

$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');


if ($_POST["inputlogin"]<>""){
    
    $query_nickname_post = mysqli_query($link,"SELECT Nickname FROM Users WHERE Nickname = '".$_POST["inputlogin"]."'");
    
    $check_nickname=mysqli_num_rows($query_nickname_post);
    
    if ($check_nickname>0 && $query_nickname_post){
    
    $query_inputpass_post = mysqli_fetch_array(mysqli_query($link, "SELECT Password_hash FROM Users WHERE Nickname = '".$_POST["inputlogin"]."'"));
    
    if (password_verify((trim($_POST["inputpass"])),$query_inputpass_post[0])){
    if (isset($_POST['inputcookie'])){
    $cookieoptions = array (
                    'expires' => time() + 60*60*24*30,
                    'path' => '/',
                    'domain' => '', // leading dot for compatibility or use subdomain
                    'secure' => false,     // or false
                    'httponly' => false,    // or false
                    'samesite' => 'Strict' // None || Lax  || Strict
                    );
    setcookie("inputpass", $query_inputpass_post[0], $cookieoptions);
    setcookie("inputlogin", $_POST["inputlogin"], $cookieoptions);
    } else {
    $cookieoptions = array (
                    'expires' => 0,
                    'path' => '/',
                    'domain' => '', // leading dot for compatibility or use subdomain
                    'secure' => false,     // or false
                    'httponly' => false,    // or false
                    'samesite' => 'Strict' // None || Lax  || Strict
                    );
    setcookie("inputpass", $query_inputpass_post[0], $cookieoptions);
    setcookie("inputlogin", $_POST["inputlogin"], $cookieoptions);
    }
    header("Location: ../account");
    
    } else {if($_POST["inputpass"]<>""){echo '<script>alert("Неправильный пароль");</script>';}}
    } else {if($_POST["inputlogin"]<>""){echo '<script>alert("Неправильный логин");</script>';}}
    }
    
    //Авторизация Cookie
    
    if ($_COOKIE["inputlogin"]<>""){
    
    $query_inputpass_cookie = mysqli_fetch_array(mysqli_query($link, "SELECT Password_hash FROM Users WHERE Nickname = '".$_COOKIE["inputlogin"]."'"));
    
    $query_nickname_cookie = mysqli_query($link,"SELECT Nickname FROM Users WHERE Nickname = '".$_COOKIE["inputlogin"]."'");
    
    if ($query_nickname_cookie){
    
    if ($query_inputpass_cookie[0]==$_COOKIE["inputpass"]){header("Location: ../account");}
    }
    }

echo '
<html>


<head>'.
$tag_head
.'<script>
function logf(){
    document.getElementById("loginformtable1").hidden = false;
    document.getElementById("loginformtable2").hidden = false;
    document.getElementById("regformtable1").hidden = true;
    document.getElementById("regformtable2").hidden = true;
    };
    function regf(){
    document.getElementById("regformtable1").hidden = false;
    document.getElementById("regformtable2").hidden = false;
    document.getElementById("loginformtable1").hidden = true;
    document.getElementById("loginformtable2").hidden = true;
    };
</script>
</head>';

echo ' 
<body>
';
echo $tag_body_header_menu;

echo
'
<div id="content">

	';
    
    echo $tag_body_content_column_one;
    



    echo '
    <div id="content_column_two">
    <table id="tableform" ">
    ';
    
    //Авторизация + куки
    
    echo '
    <tr id="loginformtable1"><td class="blue-td">
    <form action="" method="POST" name="inputloginform" enctype="multipart/form-data">
    <h1 class="text">Авторизация</h1>
    </td></tr>
    <tr id="loginformtable2"><td class="white-td">
    <p class="text">
    Логин <br><br>
    <input type=text name=inputlogin required  pattern="^.{4,16}$"> <br><br>
    Пароль <br><br>
    <input type=password name=inputpass required  pattern="^.{4,16}$"><br><br>
    <input type=submit class="btn"><br><br>
    <input type=checkbox name=inputcookie> Запомнить меня навсегда (cookie)
    ';
    //Авторизация POST
    
    
    echo ' 
    <br><br>
    <button class="btn" onclick="regf()">Зарегистрироваться</button>
    </p></td></form></tr>';
    
    
    
    
    
    
    //Регистрация
    
    echo '
    <tr hidden id="regformtable1">
    <th colspan="2" class="blue-td">
    <form action="" method="POST" name="registerform" enctype="multipart/form-data">
    <h1 class="text">Регистрация</h1>
    </td></tr>
    <tr hidden id="regformtable2">
    <td class="white-td">
    <p class="text">
    Логин <br><br>
    <input type=text name=inputloginreg required pattern="^[A-Za-z0-9]{4,16}$"> <br><br>
    Пароль <br><br>
    <input type=password name=inputpassreg required  pattern="^[A-Za-z0-9]{4,16}$"><br><br>
    <input type=submit class="btn">
    </p>
    </td>
    <td class="white-td" colspan="2"><p class="text">
    Требования к регистрации:
    <ul>
    <li> Длина никнейма от 4 до 16 символов </li>
    <li> Длина пароля от 8 до 16 символов </li>
    <li> Ваш никнейм должен быть уникальным </li>
    <li> Допускается только латинница и цифры </li>
    </ul>
    <button class="btn" onclick="logf()" >Авторизоваться</button><br><br>
    </p>
    </td>
    </tr>
    </form>
    ';
    
    
    if ($_POST["inputloginreg"]<>""){
    $dublicate=mysqli_num_rows(mysqli_query($link, "SELECT Nickname FROM Users WHERE Nickname = '".$_POST["inputloginreg"]."'"));
    if ($dublicate<1)
    {
    mysqli_query($link,"INSERT INTO `Users`(`Nickname`, `Password_hash`, `Rating`) VALUES ('".mysqli_real_escape_string($link,$_POST['inputloginreg'])."','".password_hash($_POST['inputpassreg'], PASSWORD_DEFAULT)."',0)");
    
    
    echo '<script> alert("регистрация прошла успешно вы молодец"); </script>';
    } else {if($_POST["inputloginreg"]<>""){echo '<script> alert("Такой никнейм уже занят"); </script>';}}
    }
    
    
    echo '
    </tr>
    </table>
    ';
    


echo '
    </div> <!-- end of column two -->
    <div class="cleaner">&nbsp;</div>
</div> <!-- end of content -->

</body>
</html>
';

?>
