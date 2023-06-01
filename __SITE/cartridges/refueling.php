
        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/header.php";?>
    	
        <?if(isset($query_item)):?>

            <div class="column_two_section post_div"><h1> 

            <?if($query_item=="laser"):?>

            Лазерные заправочные наборы 

            <?else:?>

            Струйные заправочные наборы 

            <?endif;?>

            </h1></div>

            <?
                $posts=mysqli_query($link, 'SELECT * FROM `Cartridges` WHERE `Type` = "ref-'.$query_item.'"'); //ref-jet

                print_cartridges($posts, 0);
            ?>
    
            </div> 

        <?endif;?>

        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/footer.php";?>

