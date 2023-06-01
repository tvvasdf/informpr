
        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/header.php";?>
    	
        <?if(isset($query_item)):?>

            <div class="column_two_section post_div"><h1> 

            <?
            switch($query_item){
                case 'fax';
                    echo 'Совместимые пленки для факса';
                    break;
                case 'jet';
                    echo 'Совместимые струйные картриджи';
                    break;                
                case 'laser';
                    echo 'Совместимые лазерные картриджи';
                    break;
                case 'matrix';
                    echo 'Совместимые матричные картриджи';
                    break;
                case 'stickers';
                    echo 'Совместимые ленты для печати наклеек';
                    break;
            }
            ?>

            </h1></div>

            <?
                $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `Type` = "comp-'.$query_item.'"'); 

                print_cartridges($posts, 0);
            ?>
    
            </div> 

        <?endif;?>

        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/footer.php";?>

