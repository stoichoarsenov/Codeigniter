<?php 
$this->load->view('templates/header');
?>
<div>
<select name="result" onchange="changeFunc(value)">
    <option value="">Брой резултати на страница</option>
    <option value="2">2</option>
    <option value="4">4</option>
    <option value="8">8</option>
    <option value="16">16</option>
  </select> 
</div>

<script> type="text/javascript">

function changeFunc($i) {
 $("#myForm").submit();
}

$( "select[name=result]" ).change(function(e) {
  var results = $(this).val();
  window.location.href = '<?php echo base_url()."/books/page/".$cat."/1/" ?>'+results+'/<?php echo ''.$ordery_by.'/'.$ordery_type.''; ?>';
});
 </script> 





<?php



    echo '
        <div class="container">
            <div class="row">
                <div class="col-sm-3">  <h4> Заглавие   
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/title/asc" ><arrow class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/title/desc"><arrow class="down"></arrow></a> 
                                        </h4> 
                </div>

                <div class="col-sm-3">  <h4> Автор
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/author/asc" ><arrow class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/author/desc"><arrow class="down"> </arrow></a> 
                                        </h4> 
                </div>

                <div class="col-sm-2">  <h4> Цена
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/price/asc" ><arrow class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/price/desc"><arrow class="down"> </arrow></a> 
                                        </h4> 
                </div>


                <div class="col-sm-4"><h4>Описание</h4></div>
        ';



foreach ($books as $books_item){

        echo '
        <div>
            <div class="col-sm-3"><a href="'.base_url().'books/getexactbook/'.$books_item['id'].'">'.$books_item['title'].'</a></div>
            <div class="col-sm-3">'.$books_item['author'].'</div>
            <div class="col-sm-2">'.$books_item['price'].'</div>
            <div class="col-sm-4">'.$books_item['description'].'</div>
            </div>
                ';                
   }
        echo '
            </div>
        </div>

            ';
$maxShow = 3;
$show_start = 1;
?>
<?php
// print_r($_SESSION);
// $_SESSION['item'] = 'asddsa';
// $var_name = $this->session->userdata('item');
// echo $var_name;
// echo $this->session->item
?>
<nav style='text-align:center;'>
        <ul class='pagination'>
                <li>  
                    <a href="<?php echo base_url()."books/page/".$cat."/1/".$recordsPerPage."/".$ordery_by."/".$ordery_type ?>"> First </a>
                </li>

                <li>
                <a href="<?php echo base_url()."books/page/".$cat."/".$prevPage."/".$recordsPerPage."/".$ordery_by."/".$ordery_type ?>"> Previous  </a>
                </li>
                
                <?php
                $active = 'class= "active"';
                // if($page == $prevPage && $page == 1 ){
                    //  $nextPage++;
                    // $maxShow = 3;
                // }
                $i = $prevPage;
                if($page >= $maxPages){
                    $i = $prevPage-1;
                }
                if($page == $maxPages || empty($books)){
                   $nextPage = $page;
                }
                if($page == $maxPages-1 && $maxPages<2){
                    $nextPage--;
                }

                if($page == 1)
                {
                    $show_start = 1;
                    $maxShow = ($maxPages >= 3 ? 3 : $maxPages);
                }
                else if($page > 1 && $page < $maxPages)
                {
                    $show_start = $page-1;
                    $maxShow = 3;
                }
                else
                {
                    $maxShow = ($maxPages >= 3 ? 3 : $maxPages);
                    $show_start = $maxPages - $maxShow+1;
                }

                if($i < 1){
                    $i++;
                }

                for($i=0; $i <= $maxShow-1; $i++){
                    // var_dump($nextPage);
                    $my_page = $i+$show_start;

                    if($my_page == $page){
                            echo '
                            <li>
                                <a '.$active.'href="'.base_url().'books/page/'.$cat.'/'.$my_page.'/'.$recordsPerPage."/".$ordery_by."/".$ordery_type.'">'.$my_page.'</a> 
                            </li>
                            ';
                    }
                    else
                    {
                        echo '
                            <li>
                                <a href="'.base_url().'books/page/'.$cat.'/'.$my_page.'/'.$recordsPerPage."/".$ordery_by."/".$ordery_type.'">'.$my_page.'</a>
                            </li>
                        ';
                    }
                }
                
                ?>
                <li>

                <a href="<?php echo base_url()."books/page/".$cat."/".$nextPage."/".$recordsPerPage."/".$ordery_by."/".$ordery_type ?>"> Next </a> 
                </li> 
                <li>
                        <a href="<?php echo base_url()."books/page/".$cat."/".$maxPages."/".$recordsPerPage."/".$ordery_by."/".$ordery_type ?>"> Last </a>
                </li>
        </ul>
</nav>   
<?php $this->load->view('templates/footer');  ?>

 
