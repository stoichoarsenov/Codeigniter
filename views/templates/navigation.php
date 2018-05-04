<?php 
$activeCategories = '';
$activeCreate = '';
$printSessionItems = '';

if($this->uri->segment(2) == 'page'){ 
    $activeCategories="active"; 
}else if ($this->uri->segment(2) == 'create'){
    $activeCreate = "active";
}else{
    $printSessionItems = "active";
}

?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
        <li class="dropdown <?=$activeCategories?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <?php
                    $titles = $category['title'];
                    $categoryIds = $category['itemId'];
                    // var_dump($totalPrice);exit();
                        foreach ($titles as $value => $title){
                            $URL_Segment = $this->uri->segment(3, 0);
                            if($URL_Segment === $title['id']){
                                echo '<li class="active"> <a href="http://www.test.com:8080/books/page/'.$title['id'].'"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            else{
                                echo '<li> <a href="http://www.test.com:8080/books/page/'.$title['id'].'"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            
                            
                        }
                ?>
        </ul>
      </li>
      <li class="<?=$activeCreate?>"><a href="http://www.test.com:8080/books/create">Add new book</a></li>
      <li class="<?=$printSessionItems?>"><a href="<?=base_url()?>books/printSessionItems"> 
                <span class="glyphicon glyphicon-shopping-cart"></span>  
                     <?php
                     if($count == 1){
                        echo '<span class="count">'.$count.'</span> Артикул <span class="TotalPrice">' .$totalPrice.'</span> лв ';
                     }
                     else if($count>1){
                        echo '<span class="count">'.$count.'</span> Артикула <span class="TotalPrice">' .$totalPrice.'</span> лв ';
                     }else{
                        echo 'Количката е празна';
                    }
                     ?>   
            </a>
         </li>
  </div>
</nav>
 

        <!-- </li> -->
<?php
// echo $this->cart_model->getTotalPrice();

?>




