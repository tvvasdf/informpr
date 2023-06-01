<?
if (($urlArr[1]=="cartridges") and ($urlArrCount==2)){

if ($urlArr[2]=="refueling"){
    header("Location: /cartridges/");
}

if ($urlArr[2]=="compatible"){
    header("Location: /cartridges/");
}

if (($urlArr[2]<>"refueling") and ($urlArr[2]<>"compatible")){
    require_once $_SERVER['DOCUMENT_ROOT'].'/bdconnect.php';

    $query_item=ucfirst($urlArr[2]);

    $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `Model` LIKE "'.$query_item.'%" AND `Type`="original"');

    if (mysqli_num_rows($posts)==0) {
        header("Location: /error/404/");
    }
    
    require_once $_SERVER['DOCUMENT_ROOT']."/cartridges/original.php";

}

}

if (($urlArr[1]=="cartridges") and ($urlArrCount==3)){

if ($urlArr[2]=="refueling"){

    if (($urlArr[3]=="laser") or ($urlArr[3]=="jet")){
        $query_item=$urlArr[3];
        require_once $_SERVER['DOCUMENT_ROOT']."/cartridges/refueling.php";
    } else {
        header("Location: /error/404/");
    }

}

if ($urlArr[2]=="compatible"){

    if (($urlArr[3]=="laser") or ($urlArr[3]=="jet") or ($urlArr[3]=="matrix") or ($urlArr[3]=="fax") or ($urlArr[3]=="stickers")){
        $query_item=$urlArr[3];
        require_once $_SERVER['DOCUMENT_ROOT']."/cartridges/compatible.php";
    } else {
        header("Location: /error/404/");
    }

}

if (($urlArr[2]<>"refueling") and ($urlArr[2]<>"compatible")){
    header("Location: /error/404/");

}

}

if (($urlArr[1]=="cartridges") and ($urlArrCount>=3)){
    header("Location: /error/404/");  
}
?>