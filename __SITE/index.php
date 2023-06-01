<?php
$link = mysqli_connect('localhost', 'root', '');
$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');


include $_SERVER['DOCUMENT_ROOT'].'/page-parts/print-cart.php';

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>'.
$tag_head
.'
<meta name="description" content="Справочник по расходникам принтеров... ghuidfhguidhgui-test">
</head>';


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
<h1>Главная</h1>';
if (mysqli_select_db($link,'informpr')){
    echo'
<form>
Поиск по сайту: <input name="q" type=text value="" required placeholder="Модель картриджа / принтера"></input><br>
<input class="btn" style="margin: 20px 0 0 0;" type=submit>
</form>
        </div>';
} else {echo "На данный момент на сайте ведутся технические работы. Просим прощения за доставленные неудобства. </div> "; echo mysqli_error($link);}
if (isset($_GET["q"])){
    if (trim($_GET["q"]!='')){
        $findtext=mysqli_real_escape_string($link, $_GET["q"]);
        $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `printers` LIKE "%'.$findtext.'%" OR `model` LIKE "%'.$findtext.'%"');
        if (mysqli_num_rows($posts)==0){
            echo '<div class="column_two_section post_div">
            По Вашему запросу <b>'.$findtext.'</b> ничего не найдено.
            </div>';
        }
    }
    print_cartridges($posts, 0);
}


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