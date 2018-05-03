<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <span class="caret"></span></a>
        <ul class="dropdown-menu">
                <?php
                    $titles = $category['title'];
                    $categoryIds = $category['itemId'];
                    
                        foreach ($titles as $value => $title){
                            $URL_Segment = $this->uri->segment(3, 0);
                            if($URL_Segment === $title['id']){
                                echo '<li class="active"> <a href="http://www.test.com:8080/books/page/'.$title['id'].'"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            else{
                                echo '<li> <a href="http://www.test.com:8080/books/page/'.$title['id'].'"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            
                            
                            // echo $product_id;
                        }
                ?>
        </ul>
      </li>
      <li><a href="http://www.test.com:8080/index.php/books/create">Add new book</a></li>
      <li><a href="<?=base_url()?>books/printSessionItems"> 
                <span class="glyphicon glyphicon-shopping-cart"></span>  
                     <?php
                     if($count == 1){
                        echo $count." Артикул";
                     }
                     else if($count>1){
                        echo $count." Артикула";
                     }else{
                        echo 'Количката е празна';
                    }
                     ?>   
            </a>
         </li>
  </div>
</nav>
 

        <!-- </li> -->





