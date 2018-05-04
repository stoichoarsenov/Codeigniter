
<?php $this->load->view('templates/header');  ?>

<div class="container-fluid">
    <!-- Control the column width, and how they should appear on different devices -->
    <div class="row">
      <div class="col-sm-3">Title</div>
      <div class="col-sm-2">Quantity</div>
      <div class="col-sm-1">Price</div>
      <div class="col-sm-1">Total price</div>
      <div class="col-sm-1">Remove item</div>
      <!-- <div class="col-sm-3">Add quantity</div> -->
    </div>
   
<?php
// echo '<pre>',print_r($itemTotalPrice,1),'</pre>'; 

// echo '<pre>'.print_r($bookInfo,1).'</pre>';
// echo '<pre>',print_r($bookInfo,1),'</pre>';
if(isset($bookInfo)){
    foreach($bookInfo as $key => $item){
        // foreach($bookInfoItem as $item){
            
        echo '<div class="row">';
        echo '<div class="col-sm-3">'.$item[0]['title'].'</div>';
        echo '<div class="col-sm-2"><input class="addQuantityToCart" type="number" min="1" data-id="'.$item[0]['id'].'" placeholder="'.$quantity[$key].'"></input></div>';
        // echo '<div class="col-sm-1">'.$quantity[$key].'</div>';
        echo '<div class="col-sm-1">'.$item[0]['price'].'</div>';
        echo '<div class="col-sm-1" id="'.$item[0]['id'].'">'.$itemTotalPrice[$key].'</div>';
        echo '<div class="col-sm-1"><button class="btn btn-danger remove_from_cart" data-id="'.$item[0]['id'].'"> Remove </button></div>';
        echo '</div>';
        // }
    }
    } else {
        echo 'Количката е празна';
    }
?>
    
</div>
<button class="btn btn-success" style="display: block;
                                        margin: 75 auto;
                                        text-align: center;"> Продължи с поръчката  <span class="totalPrice"> <?=$totalPrice?> </span> лв. </button>

<!-- </div> -->
 <script type="text/javascript">
 </script>

 
<script type="text/javascript">
$( '.remove_from_cart' ).click(function(e) {
    e.preventDefault();
    // location.reload();
    var book_id = $(this).attr('data-id');

        $.ajax({
            type: "POST",   
            url: `/books/removeItemsFromSession/` + book_id,
            dataType: 'json',
            // data: data, 
        })
            .done(function(data) {
                    if(data.data === "deleted"){
                        alert('Изтрит');
                        location.reload();
                    }
                    else{
                        // alert(data.data);
                        // alert('not deleted');
                    }
                })

});
</script>

<script type="text/javascript">
$('.addQuantityToCart').change(function(e) {
    var book_id = $(this).attr('data-id');
    var quantity = Math.abs($(this).val());
    // $(this).val() = quantity;

        $.ajax({
            type: "POST",   
            url: `/books/setItemQuantity/` + book_id + `/` + quantity,
            dataType: 'json',
            // data: data, 
        }).done(function(data){
            $('.TotalPrice').text(data.updated_items.totalPrice);
            $('#'+book_id+'').text(data.updated_items.totalPriceForItem);
        })

});
</script>

<?php $this->load->view('templates/footer');  ?>
