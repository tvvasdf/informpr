<?php
$link = mysqli_connect('localhost', 'root', '');
if (!mysqli_select_db($link,'informpr')){header('Location: /');}
?>