﻿<?php

$tag_head = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/head.txt');
$tag_body_content_column_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_one');
$tag_body_content_column_two = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/content_column_two');
$tag_body_bottom_panel = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/bottom_panel');
$tag_body_header_menu = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/page-parts/body/header_menu');


echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>'.
$tag_head
.'</head>';

echo ' 
<body>
'. 
$tag_body_header_menu
.

'
<div id="content">

	'.
    $tag_body_content_column_one;

echo ' 

<div id="content_column_two">
    
    	<div class="column_two_section post_div">
        <h1> О картриджах </h1>
        <p>Картридж для принтера – это основная деталь, без которой ни одно периферийное устройство не будет функционировать (кроме МФУ в режиме сканера). Ведь основное предназначение расходника заключается в хранении красящего вещества и переносе его на бумажный лист. Внешне это изделие напоминает пластмассовую коробку, состоящую из множества технически сложных деталей и контейнера с краской (тонером). Существует несколько видов расходников, которые различаются между собой не только размерами и внешним видом, но и технологией изготовления, характеристиками и внутренними компонентами.

 
        <h2>Какие есть виды картриджей для принтера</h2>
        
         
        <img style="float: right; margin-left: 25px; margin-right: 25px;" src="cartridge.jpg">
        <p>На сегодняшний день выделяют три типа расходников к оргтехнике:
        <ul>
            <li>Матричные. Активно использовались на матричных принтерах в конце прошлого и в начале этого века. Имеют несложную конструкцию, которая состоит из корпуса, специального протяжного механизма, ленты и валиков. Единственные изделия, где в качестве красящего вещества применяется пропитанная чернилами лента. Нынче производство матричной техники занимает небольшой процент рынка, так как эта продукция больше подходит для использования в банках, магазинах (кассовые аппараты) и государственных учреждениях, чем для эксплуатации частными пользователями.
            <li>Струйные. Заправляются монохромными или цветными чернилами. Бывают одноцветными или многоцветными. В современном мире являются одними из самых распространенных. Используются, как правило, для создания высококачественных цветных отпечатков и фотографий (особенно на МФУ). Внешне небольшие, состоят из контейнера с краской, печатающей головки, крышки и контактных пластин.
            <li>Лазерные. Как и струйные, входят в число самых популярных. Однако лазерные устройства в основном используются для массовой черно-белой печати документов и прочих текстовых материалов. Поэтому они применяются в офисах, учебных заведениях и в различных копировальных центрах. Стоит отметить, что эти изделия самые сложные в изготовлении, так как состоят из множества деталей и механизмов – фотобарабана, нескольких различных лезвий и валов, уплотнителей и бункера для тонера.
        </ul></p>
        
        <p>Что касается дополнительной заправки, то ее можно осуществить для любого вышеуказанного изделия. Тем не менее, технология заправки для каждого картриджа значительно отличается. Поэтому самостоятельно лучше этого не делать, а обратиться к соответствующему мастеру. </p>
        
        <h2>И еще несколько видов</h2>
 
        <p>Кроме того, по типу производства эти расходники делят на:
        <ul>
            <li>оригинальные — те, которые выпущены производителем самой печатной техники под определенные ее модели, они характеризуются не только качеством, но и очень высокой стоимостью;
            <li>совместимые — те, которые являются полными аналогами оригинальных по качеству и ресурсу, только выпускаются сторонними компаниями и продаются по доступной цене;
            <li>восстановленные — оригинальные или совместимые картриджи, которые уже были использованы, после чего прошли ремонт и повторную заправку, по стоимости дешевле новых оригинальных, но дороже совместимых.
            <li>перезаправляемые (ПЗК) — это один из видов совместимых картриджей, который, в отличие от остальных, является многоразовым и может перезаправляться.
            </ul></p>
        </div>

    </div> <!-- end of column two -->
    <div class="cleaner">&nbsp;</div>
</div> <!-- end of content -->';

echo ' 
<div id="bottom_panel">'.
$tag_body_bottom_panel.
	
'</div> <!-- end of bottom panel -->

</body>
</html>'

?>