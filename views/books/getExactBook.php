
<?php $this->load->view('templates/header');  ?>
<div class="container">

  <div class="row">
        <div class="col-sm-3">
            Title
        </div>
        <div class="col-sm-3">
            Author
        </div>
        <div class="col-sm-3">
           Description
        </div>
        <div class="col-sm-3">
            Price
        </div>
    <!-- </div> -->
  </div>
<br><br>
    <div class="row">
        <div id="title" class="col-sm-3">
            <?php echo $result['title']; ?>
        </div>
        <div id="author" class="col-sm-3">
            <?php echo $result['author']; ?>
        </div>
        <div class="col-sm-3">
            <?php echo $result['description']; ?>
        </div>
        <div id="price" class="col-sm-3">
            <?php echo $result['price']; ?>
        </div>
    </div>
<br><br>
<div class="row">

<!-- <form method="POST" id="getQuantity">   -->
        <div class="col-sm-3">
                <label for="quantity">
                        Quantity
                </label>
        </div>
        <div class="col-sm-3">
                <input type="number" name="quantity" min="0" placeholder="1" id="quantity" class="form-control title" /> </input>
        </div>
        <div class="col-sm-3">
                <button class="btn btn-success add_to_cart" data-id="<?=$result['id']?>">Add to cart</button>
        </div>
<!-- </form> -->

</div>

</div>


<!-- Ако клиента желае да закупи даден артикул (да го добави в количката) да се изпълни
    метода /books/setSessionData 
    Въпрос1?
        -На този метод да му задам ли всички необходими параметри или да се опитвам да ги предам чрез метода, с който извеждам желаната книга
    Въпрос2?
        -По какъв начин да взема параметрите, ако е необходимо да предам параметрите чрез URL (необходимо ли е да ги кодирам като json и да заъплня един такъв масив с данни, които да предам като параметър... )
        - например /books/setSessionData/ + $sessiondata , която ще бъде енкодната както е показано по горе
    Въпрос3?
        -проверката на входните данни (независимо че повечето без КОЛИЧЕСТВО са от мен) проверятват ли се и ако да къде в скрипта отдолу или в контолера?
    Въпрос4? 
        
 -->

<script type="text/javascript">
$( '.add_to_cart' ).click(function(e) {
    // e.preventDefault();
    // location.reload();
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



