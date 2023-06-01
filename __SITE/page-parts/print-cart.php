<?php

function locfunc($color_str){
    echo '<div class="color-square" style="background: '.$color_str.'; margin-left: 5px"></div>';
}



function print_cartridges($posts, $rating){

    if (isset($_GET['q'])){
        $search_text=trim($_GET['q']);
        if (trim($search_text)==""){
            die();
        }
    }

    if ((isset($search_text)) and ($search_text!='') and (mysqli_num_rows($posts)!=0)){
switch (mysqli_num_rows($posts)) {

    case ((mysqli_num_rows($posts)%10)>=5) and ((mysqli_num_rows($posts)%10)<=9): 
    case ((mysqli_num_rows($posts)%10) == 0):
    case ((mysqli_num_rows($posts))>=11) and ((mysqli_num_rows($posts))<=19): 
        echo '<div class="column_two_section post_div"> По Вашему запросу <b>'.$search_text.'</b> было найдено '.mysqli_num_rows($posts).' результатов.</div>';
        break;

    case ((mysqli_num_rows($posts)%10) == 1): 
        echo '<div class="column_two_section post_div"> По Вашему запросу <b>'.$search_text.'</b> был найден '.mysqli_num_rows($posts).' результат.</div>'; 
        break;

    case ((mysqli_num_rows($posts)%10) == 2):
    case ((mysqli_num_rows($posts)%10) == 3):
    case ((mysqli_num_rows($posts)%10) == 4):
        echo '<div class="column_two_section post_div"> По Вашему запросу <b>'.$search_text.'</b> было найдено '.mysqli_num_rows($posts).' результата.</div>';
        break;


}}

while($row = mysqli_fetch_array($posts))// получаем все строки в цикле по одной
{
   /* echo '<script>
    function togglehideshow() {
        document.getElementById("printers-drop-id").classList.toggle("show");
      }
      </script>';*/
    echo '<div class="column_two_section post_div">
    <table><tr>
    ';
    echo '<td class="img-td"><img src="/images/cart/'.$row['idpost'].'.jpg" class="img-cart"></td>';
    echo '<td><div class="text-td">';
    


    $brand=stristr($row['model'],' ', true);
    $brands_comp=explode(',', $row['carttype']); 
    
    $a_tag_model_cart='<a class="pr-cart-link" href="/?q='.str_ireplace(' ','+',trim($row['model'])).'">'.$row['model'].'</a>';


/****************************************************************ВЫВОДИМ ЗАГОЛОВОК**********************************************************************************/
if ($row['type']=='original'){

    $chklaser=stripos($row['carttype'],'Лазерный'); //проверить вхождение подстроки в строку без учёта регистра
    $chkjet=stripos($row['carttype'],'Матричный');
    $chkmatrix=stripos($row['carttype'],'Струйный');

if (($chklaser===false) and ($chkjet===false) and ($chkmatrix===false)){
    echo '<h3>'.$row['carttype'].' '.$a_tag_model_cart.' (оригинал)</h3>';
    } else {
    echo '<h3>Картридж '.$a_tag_model_cart.' (оригинал)</h3>';}
}

switch ($row['type']){
    case 'comp-laser':
    case 'comp-jet':
    case 'comp-matrix': echo '<h3>Картридж '.$a_tag_model_cart.' (совместимый)</h3>';
        break;

    case 'comp-fax': echo '<h3>Пленка для факса '.$a_tag_model_cart.' (совместимая)</h3>';
        break;

    case 'comp-stickers': echo '<h3>Ленты для печати наклеек '.$a_tag_model_cart.' (совместимые)</h3>';
        break;

    case 'ref-laser': 
    case 'ref-jet': 
        echo '<h3>Заправочный набор '.$a_tag_model_cart.'</h3>';
        break;
    }
    

/*****************************************************************ВЫВОДИМ РЕСУРС КАРТРИДЖА***************************************************************************/
    if (mb_substr($row['res'],0,6)=='[othr]'){
        echo '<br><b>Ресурс:</b> '.str_replace('[othr]','',$row['res']);}
     else {
        echo '<br><b>Ресурс:</b> '.$row['res'].' страниц формата А4 при 5% заполнении страницы.';
    }
/******************************************************************ВЫВОДИМ ВИД РАСХОДНИКА И СОВМЕСТИМЫЕ БРЕНДЫ************************************************************************/
    if ($row['type']=='original') 
    {
        echo '<br><b>Вид расходника:</b> ';
    }
    else
    {
        switch ($row['type']){
            case 'comp-laser':
            case 'ref-laser': 
                echo '<br><b>Вид расходника:</b> Лазерный ';
                break;

            case 'comp-jet':
            case 'ref-jet': 
                echo '<br><b>Вид расходника:</b> Струйный ';
                break;

            case 'comp-matrix': echo '<br><b>Вид расходника:</b> Матричный ';
                break;
            case 'comp-fax': echo '<br><b>Вид расходника:</b> Пленка для факса ';
                break;
            case 'comp-stickers': echo '<br><b>Вид расходника:</b> Ленты для печати наклеек ';
                break;
        }
        echo '<br><b>Совместимый с брендами:</b> ';
    }

    echo $row['carttype'];
/*******************************************************************ВЫВОДИМ ЦВЕТ КАРТРИДЖА + CSS**********************************************************/
    echo '<br><b>Цвет:</b> '.$row['color'];
    


    switch($row['color']){
        case 'Чёрный': locfunc('black'); break;
        case 'Пурпурный': locfunc('magenta'); break;
        case 'Жёлтый': locfunc('yellow'); break;
        case 'Голубой': locfunc('cyan'); break;
        case 'Цветной': 
            echo '<div class="color-square" style="background: cyan; margin-left: 5px"></div><div class="color-square" style="background: magenta;"></div><div class="color-square" style="background: yellow;"></div><div class="color-square" style="background: black;"></div>
            '; 
            break; 
    }

/******************************************************************ВЫВОДИМ СОВМЕСТИМЫЕ ПРИНТЕРЫ*****************************************************************************/
    echo '<br><br><b>Совместимые принтеры:</b> </td></tr><tr><td></td><td><div class="printers-list text-td">';


    if($row['type']=='original'){
        foreach(explode('|/|/|s|p|l|i|t|\|\|',str_ireplace($brand, '|/|/|s|p|l|i|t|\|\| '.$brand,$row['printers'])) as $value){
        echo '<a class="link-item pr-cart-link" href="/?q='.str_ireplace(' ','+',trim($value)).'">'.trim($value).'</a>';
        }

    } else {
    $new_printers_list=$row['printers'];
    for ($i = 0; $i <= count($brands_comp)-1; $i++) {
        $new_printers_list=str_ireplace($brands_comp[$i], '|/|/|s|p|l|i|t|\|\| '.$brands_comp[$i],$new_printers_list);
    } 

    foreach(explode('|/|/|s|p|l|i|t|\|\|', $new_printers_list) as $value){
        echo '<a class="link-item pr-cart-link" id="'.$i.'" href="/?q='.str_ireplace(' ','+',trim($value)).'">'.trim($value).'</a>';
        
    }
        }
    
 

    //var_dump($new_printers_list);
    //var_dump($brands_comp);
    //var_dump(' Canon', explode($row['printers'], 50));
   

    echo '</div>';
    /*
    echo '<br><b><button onclick="togglehideshow()" class="printers-dropbtn">Совместимые принтеры</button><div ></b> ';
    echo '<div id="printers-drop-id" class="printers-drop">'.$row['printers'].'
    </div>';
    */


    /*******************************************************************ВЫВОДИМ ДОП ИНФОРМАЦИЮ*****************************************************************************/
    if ($rating>0) {echo '<br><br>Дата: '.$row['date'];
        echo '<br>ID записи: '.$row['idpost'];
        echo '<br>Автор: '.$row['author'];}

        
    echo '</div></td></tr></table></div>';
}
}
?>