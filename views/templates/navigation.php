<?php 
$activeCategories = '';
$activeCreate = '';
$printSessionItems = '';
$registerUser = '';
$userLogin = '';

if($this->uri->segment(2) == 'page'){ 
    $activeCategories="active"; 
}else if ($this->uri->segment(2) == 'create'){
    $activeCreate = "active";
}else if ($this->uri->segment(2) == 'register'){
    $registerUser = "active";
}else if ($this->uri->segment(2) == 'login'){
    $userLogin = "active";
}else{
    $printSessionItems = "active";
}

?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar">
        <li class="dropdown <?=$activeCategories?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Категории <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <?php
                    $titles = $category['title'];
                    $categoryIds = $category['itemId'];
                        foreach ($titles as $value => $title){
                            $URL_Segment = $this->uri->segment(3, 0);
                            if($URL_Segment === $title['id']){
                                echo '<li class="active"> <a href="http://www.test.com:8080/books/page/'.$title['id'].'/1/2/title/asc"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            else{
                                echo '<li> <a href="http://www.test.com:8080/books/page/'.$title['id'].'/1/2/title/asc"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            
                            
                        }
                ?>  
            </ul>
      </li>

<li class="<?=$activeCreate?>"><a href="http://www.test.com:8080/books/create">Добави книга</a></li>
    <li class="<?=$printSessionItems?>">
        <a href="<?=base_url()?>books/printSessionItems"> 
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
</ul>
<ul style="float: right" class="nav navbar-nav navbar-right">
    <li class=<?=$registerUser?> >  <a href="/user/register"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
    <li class=<?=$userLogin?> >     <a href="/user/login"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
</ul>
        
  </div>
</nav>





