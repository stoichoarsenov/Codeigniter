
<?php $this->load->view('templates/header');  ?>
<div class="container-fluid">
    <!-- Control the column width, and how they should appear on different devices -->
    <div class="row">
      <div class="col-sm-3">Title</div>
      <div class="col-sm-1">Quantity</div>
      <div class="col-sm-1">Price</div>
      <div class="col-sm-1">Total price</div>
      <div class="col-sm-1">Remove item</div>
      <!-- <div class="col-sm-3">Add quantity</div> -->
    </div>
   
<?php
if(isset($items)){
    foreach($items as $item){
        echo '<div class="row">';
        echo '<div class="col-sm-3">'.$item['title'].'</div>';
        echo '<div class="col-sm-1">'.$item['quantity'].'</div>';
        echo '<div class="col-sm-1">'.$item['price'].'</div>';
        echo '<div class="col-sm-1">'.$item['total_price'].'</div>';
        echo '<div class="col-sm-1"><button class="btn btn-danger remove_from_cart" data-id="'.$item['id'].'"> Remove </button></div>';
        // echo '<div class="col-sm-"><input type="text" name="firstname"></div>';
        // echo '<div class="col-sm-1"><button class="btn btn-success remove_from_cart" data-id="'.$item['id'].'"> Add quantity </button></div>';
        echo '</div>';
    }
    } else {
        echo 'Количката е празна';
    }
?>
    <!-- </div> -->
</div>
 <script type="text/javascript">
 </script>

 
<script type="text/javascript">
$( '.remove_from_cart' ).click(function(e) {
    e.preventDefault();
    location.reload();
    var book_id = $(this).attr('data-id');

        $.ajax({
            type: "POST",   
            url: `/books/removeItemsFromSession/` + book_id,
            dataType: 'json',
            // data: data, 
        })
            .done(function(data) {
                    if(data.data === "deleted"){
                        location.reload();
                    }
                    else{
                        alert('not deleted');
                    }
                })

});
</script>
<?php $this->load->view('templates/footer');  ?>
