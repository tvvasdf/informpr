
        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/header.php";?>
    	
        <?if(isset($query_item)):?>
            <div class="column_two_section post_div"><h1> Оригинальные картриджи <?=$query_item?> </h1> </div>
        
            <?
            print_cartridges($posts, 0);
            ?>
    
            </div> 

        <?endif;?>

        <?require_once $_SERVER['DOCUMENT_ROOT']."/page-parts/footer.php";?>
