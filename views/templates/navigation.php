<?php 
$activeCategories = '';
$activeCreate = '';
$printSessionItems = '';
$registerUser = '';
$userLogin = '';
$profile = '';
$changepassword = '';
$adress = '';
$photo = '';
$profileInfo = '';

if($this->uri->segment(2) == 'page'){ 
    $activeCategories="active"; 
}else if ($this->uri->segment(2) == 'create'){
    $activeCreate = "active";
}else if ($this->uri->segment(2) == 'register'){
    $registerUser = "active";
}else if ($this->uri->segment(2) == 'login'){
    $userLogin = "active";
// }else if ($this->uri->segment(1) == 'user'){
    // $profile = "active";
}else if($this->uri->segment(2) == 'changepassword'){
    $changepassword = "active";
    $profile = "active";
}else if($this->uri->segment(2) == 'adress'){
    $adress = "active";
    $profile = "active";
}else if($this->uri->segment(2) == 'photo'){
    $photo = "active";
    $profile = "active";
}else if($this->uri->segment(2) == 'info'){
    $profileInfo = "active";
    $profile = "active";
}else{
    $printSessionItems = "active";
}
?>
<div id="main-menu">
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
                                echo '<li class="active"> <a href="/books/page/'.$title['id'].'/1/2/title/asc"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            else{
                                echo '<li> <a href="/books/page/'.$title['id'].'/1/2/title/asc"> '.$title['title'].' '.$categoryIds[$value].' </a></li>';
                            }
                            
                            
                        }
                ?>  
            </ul>
      </li>

<li class="<?=$activeCreate?>"><a href="/books/create">Добави книга</a></li>
    <li class="<?=$printSessionItems?>">
        <a href="/books/printSessionItems"> 
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

<?php
if ($isLogged == true){
?> 
<ul style="float: right" class="nav navbar-nav navbar-right">
    <!-- <li class=<?=$profile?> >  <a href="/user/profile"><span class="glyphicon glyphicon-user"></span> Профил</a></li> -->

    <li class="dropdown <?=$profile?>"><a class="dropdown-toggle" data-toggle="dropdown" href="/user/profile/profile"><span class="glyphicon glyphicon-user"></span> <?php echo $currUserName ?><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li class=<?=$profileInfo?>> <a href="/user/info">редактирай информация</a></li>
                <li class=<?=$changepassword?> > <a href="/user/changepassword">смени парола</a></li>
                <li class=<?=$photo?>> <a href="/user/photo">Промени профилната снимка</a></li>
                <li class=<?=$adress?> > <a href="/user/adress">Aдреси за доставка</a></li>
            </ul>
    </li>
       
    
    <li> <a href="/user/logout"><span class="glyphicon glyphicon-log-in"></span> Изход</a></li>


<?php }else{ ?>
<ul style="float: right" class="nav navbar-nav navbar-right">
    <li class=<?=$registerUser?> >  <a href="/user/register"><span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
    <li class=<?=$userLogin?> >     <a href="/user/login"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
</ul>

<?php } ?>        
  </div>
</nav>
</div>




