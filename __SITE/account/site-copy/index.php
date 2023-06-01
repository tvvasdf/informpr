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
if ((!$authorizedbool) or ($rating_db<5)){header("Location: /login");}



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
        <h1> Резервная копия сайта </h1>
        <p>
        Резервная копия сайта - это резервная копия всех файлов сайта включая базу данных MySQL. База данных MySQL находится в главной папке в архиве и будет называться <b>database.sql</b>.
        </p>
        <form enctype="multipart/form-data" method="post">
        <input type="submit" name="create-copy" class="btn" style="margin: 5px;" value="Создать резервную копию"></input>
        </form>
        </div>';



        $res_copies = glob($_SERVER['DOCUMENT_ROOT'].'/account/res-copies/res-copy_*.zip');
        arsort($res_copies); //сортируем массив по убыванию (сначала новые файлы)
        if ( sizeof($res_copies) ) //проверяем массив на пустоту
{

    foreach($res_copies as $value){
        $date=explode('_',str_replace('.zip','',str_replace('/home/f0675437/domains/informpr.ddns.net/public_html/account/res-copies/res-copy_','',$value)));
        $date[0]=str_replace('-','.',$date[0]);
        $date[1]=str_replace('-',':',$date[1]);
        $file_name=str_replace('/home/f0675437/domains/informpr.ddns.net/public_html','',$value);
echo '<div class="column_two_section post_div">
<h1> Резервная копия от '.$date[0].' - '.$date[1].'</h1>';
echo 'Вес файла: '.(round(stat($value)['size']/1024/1024, 1)).' Мбайт'; //переводим байты в мбайты и округляем до 1 запятой (round)

echo '<a class="btn panel" download href="'.$file_name.'">Скачать резервную копию</a>';
echo '<form enctype="multipart/form-data" method="post">
<input type="hidden" name="delete" value="'.$file_name.'"></input> 
<input type="submit" class="btn" style="margin: 5px;" value="Удалить эту резервную копию"></input>
</form>';
echo '</div>';

//<input type="hidden" name="delete" value="test"></input> 
//^^^ делаем post запрос одним нажатием кнопки
}

}
        else
{
    echo '
    <div class="column_two_section post_div">
    Резервные копии отсутствуют.
    </div>
    ';
}


if (isset($_POST['delete']))
{
    unlink($_SERVER['DOCUMENT_ROOT'].$_POST['delete']);
    echo '<meta http-equiv="refresh" content="0;URL=redirect.php" />';
}

if(isset($_POST['create-copy'])) {
// Get real path for our folder
$rootPath = $_SERVER['DOCUMENT_ROOT'];
// Initialize archive object
$zip = new ZipArchive();
$zip->open($_SERVER['DOCUMENT_ROOT']."/account/res-copies/res-copy_".date('d-m-y_H-i').".zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
//@var SplFileInfo[] $files 
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $pos      = strripos($file, 'res-copy_');
        if ($pos === false) {
        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
        }
    }
}
include 'backupfunc.php';
backupDatabaseAllTables('localhost', 'f0675437_root', 'roma228','f0675437_informpr_bd');
$zip->addFile('database.sql');
$zip->close();
unlink('database.sql');
echo '<meta http-equiv="refresh" content="0;URL=redirect.php" />';
}


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