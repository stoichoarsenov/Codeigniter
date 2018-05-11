<?php 
$this->load->view('templates/header'); // APP_PATH.'views/dflwekqdh.php'
?>
<div>

<?PHP
$page_records_options=array(2,4,8,16);

echo '<select name="result">';
foreach($page_records_options as $rec_option){
    $selected='';
    if($rec_option == $recordsPerPage ){
        $selected=' selected ';
    }
    echo '<option '.$selected.' value="'.$rec_option.'">'.$rec_option.' на страница</option>';    
}
echo '</select>';

$titleActive = '';
$arrowTitleUpActive = '';
$arrowTitleDownActive = '';

$authorActive = '';
$arrowAuthorUpActive = '';
$arrowAuthorDownActive = '';

$priceActive = '';
$arrowPriceUpActive = '';
$arrowPriceDownActive = '';


if($this->uri->segment(6,0) == 'title'){
    $titleActive = 'style = "color:red"';

    if($this->uri->segment(7,0) == 'asc'){
        $arrowTitleUpActive = 'style = "border-color:red"';
    }
    else if($this->uri->segment(7,0) == 'desc'){
        $arrowTitleDownActive = 'style = "border-color:red"';
    }
}
if ($this->uri->segment(6,0) == 'author'){
    $authorActive = 'style = "color:red"';

    if($this->uri->segment(7,0) == 'asc'){
        $arrowAuthorUpActive = 'style = "border-color:red"';
    }
    else if($this->uri->segment(7,0) == 'desc'){
        $arrowAuthorDownActive = 'style = "border-color:red"';
    }
}

if ($this->uri->segment(6,0) == 'price'){
    $priceActive = 'style = "color:red"';

    if($this->uri->segment(7,0) == 'asc'){
        $arrowPriceUpActive = 'style = "border-color:red"';
    }
    else if($this->uri->segment(7,0) == 'desc'){
        $arrowPriceDownActive = 'style = "border-color:red"';
    }
}


    

    echo '
        <div class="container">
            <div class="row">
                <div class="col-sm-3">  <h4 '.$titleActive.'> Заглавие
                
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/title/asc" ><arrow '.$arrowTitleUpActive.' class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/title/desc"><arrow '.$arrowTitleDownActive.' class="down"></arrow></a> 
                                         
                </div>

                <div class="col-sm-3">  <h4 '.$authorActive.'> Автор
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/author/asc" ><arrow '.$arrowAuthorUpActive.' class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/author/desc"><arrow '.$arrowAuthorDownActive.' class="down"> </arrow></a> 
                                        </h4> 
                </div>

                <div class="col-sm-2">  <h4 '.$priceActive.'> Цена
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/price/asc" ><arrow '.$arrowPriceUpActive.' class="up"></arrow></a>      
                                            <a href="'.base_url().'books/page/'.$cat.'/1/'.$recordsPerPage.'/price/desc"><arrow '.$arrowPriceDownActive.' class="down"> </arrow></a> 
                                        </h4> 
                </div>


                <div class="col-sm-3"><h4>Описание</h4></div>
                <div class="col-sm-1"><h4>Купи</h4></div>
        ';


foreach ($books as $books_item){

        echo '
        <div>
            <div class="col-sm-3"><a href="'.base_url().'books/getexactbook/'.$books_item['id'].'">'.$books_item['title'].'</a></div>
            <div class="col-sm-3">'.$books_item['author'].'</div>
            <div class="col-sm-2">'.$books_item['price'].'</div>
            <div class="col-sm-3">'.$books_item['description'].'</div>
            <div class="col-sm-1">
                    <button class="btn btn-success add_to_cart" data-id="'.$books_item['id'].'">Add to cart</button>
        </div>
        
            </div>
                ';                
   }
        echo '
            </div>
        </div>

            ';

            // работи , но с числа по малки от максималния брой страници
$maxShow = 5;
if($maxShow > $maxPages){
    $maxShow = $maxPages;
}

$show_start = 1;

$active = 'class= "active"';

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
                /**
                 * Ако е една страница или изобщо няма книги 
                 * Да покаже че общо има една страница
                 */

                if($page == $maxPages || empty($books)){
                   $nextPage = $page;
                }
                
                if($page > 0 && $page < $maxPages){
                        $show_start = $page - intval($maxShow/2);
                    
                    if($show_start < 1){
                            $show_start = 1;
                        }
                }
                else
                {
                    $maxShow = ($maxPages >= $maxShow ? $maxShow : $maxPages);
                    $show_start = $maxPages - $maxShow+1;
                }

                if($maxShow == 0){
                    $maxShow = 1;
                }
                for($i=0; $i <= $maxShow-1 ; $i++){                    

                    /**
                     * Използва се за изключване на излишните страници
                     * променливата var е равна на  максималният брой страници - броя страници, които трябва да бъдат изведени
                     * Тоест ще покаже най високия възможен елемент от ляво, началото на пагинацията. 
                     */
                    if($maxPages >= $maxShow){
                            $var = $maxPages - $maxShow;
                            $var = $var+1;
                        
                                if($show_start > $var){
                                    $show_start = $var;
                                }
                    }
                    $my_page = $i + $show_start;
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

<script> type="text/javascript">

$( document ).ready(function() {
    console.log( "ready!" );
    $( "select[name=result]" ).change(function(e) {
        var results = $(this).val();
        window.location.href = '<?php echo base_url()."/books/page/".$cat."/1/" ?>'+results+'/<?php echo ''.$ordery_by.'/'.$ordery_type.''; ?>';
    });    
});



$( '.add_to_cart' ).click(function(e) {
    var data = {};
    var book_id = $(this).attr('data-id');

    data.quantity = $('#quantity').val(); 
    data.item = $('.count').val();
    data.itemId = book_id;  
   

        $.ajax({
            type: "POST",   
            url: `/books/setSesssionData/`,
            dataType: 'json',
            data: data,
            
        }).done(function(data) {
            console.log(data.message);
            // alert(JSON.stringify(data.data))
                if (data.data.message == "quantity"){
                    // alert(JSON.stringify(data.data.totalPrice));
                    $('.TotalPrice').text(data.data.totalPrice);
                    $('.count').text(data.data.count);
                    //    alert("Успешно добавихте елемент в количката");
                    //    location.reload();
                 }else if(data.data.message == "new"){
                    //  alert(data.data.message);
                    $('.TotalPrice').text(data.data.totalPrice);
                    $('.count').text(data.data.count);
                 }else{
                    location.reload();
                 }
        })

});
</script>
<?php $this->load->view('templates/footer');  ?>

 
