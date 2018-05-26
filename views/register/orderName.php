<?php $this->load->view('templates/header');  ?>

<?php 

$attributes = array('role'=>"form", 'id'=>"createTempRegister");
echo form_open('register/orderName',$attributes); ?>


<div class="container">
  <div class="form-row">
    <div class="form-group">
      <label for="name">Име</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Име">
    </div>


    <div class="form-group">
      <label for="familyName">Фамилия</label>
      <input type="text" class="form-control" name="familyName" id="familyName" placeholder="Фамилия">
    </div>


    <div class="form-group">
      <label for="Email">Email</label>
      <input type="text" class="form-control" name="txtEmail" id="txtEmail" placeholder="Email">
    </div>


    <div class="form-group">
      <label for="number">Номер</label>
      <!-- <div class="input-group"> -->
        <!-- <span class="input-group-addon" id="basic-addon1">+359</span> -->
        <input value="+359" type="text" class="form-control" name="number"  id="number">
      <!-- </div> -->
    </div>


    <div class="form-group">
      <label for="adress">Адрес</label>
      <input type="text" class="form-control" name="adress" id="adress" placeholder="Адрес">
    </div>


    <div class="form-group col-md-6">
      <label for="city">Град</label>
        <select name="chooseCity" id="chooseCity" class="form-control">
          <option value="choose" disabled selected> Избери град </option>
          <option value="Sofia">София</option>
          <option value="Burgas">Бургас</option>
          <option value="Varna">Варна</option>
          <option value="StaraZagora">Стара загора</option>
        </select>
    </div>
    
    <div name="chooseCity" id="chooseCity" class="form-group col-md-6">
      <label for="Office">Офис</label>
      <select name="selectOffice" id="selectOffice" class="form-control" disabled="disabled">

        </select>
    </div>


    <div class="form-group">
      <label for="comment">Коментар към поръчката</label>
      <input type="text" class="form-control" name="comment" id="comment" placeholder="Коментар към поръчката">
    </div>


    <div class="form-group col-md-6">
        <input type="submit" id="saveCart" class="btn btn-success center-block" value="Завърши поръчката">
    </div>


    <div class="form-group col-md-6">
      <input type="button" id="emptyCart" class="btn btn-danger center-block" value="Изчисти количката">
    </div>
  </div>
  <?php echo form_close(); ?>

<script type="text/javascript">    
  $('#emptyCart').click(function() {
      $.ajax({
          url: '/BuyItemsInCart/clearCard',
          method: 'POST',
          // data: data
      })
      .done(function(status) {
          if (status == "deleted"){
            // alert(data.message);
              window.location.href = "/books/page/33/1/2/title/asc";
          }
          else{
            window.location.href = "/books/page/33/1/2/title/asc";
          }
        })
  })

  

$('#chooseCity').change(function(e){
  // if($('#createTempRegister').valid() == true){
  $('#selectOffice').attr("value",'').text('');
  var choosedCity = $(this).val();
    e.preventDefault()
      $.ajax({
        url: '/BuyItemsInCart/chooseShop/'+choosedCity,
        method: 'POST',
        dataType: 'json',
        data: choosedCity,
      }).done(function(data){
            if(typeof data.shopArr != 'undefined')
            {
              $.each(data.shopArr,function(key,value)
              {
                $('#selectOffice').prop("disabled", false);
                $('#selectOffice')
                .append($("<option></option>")
                    .attr("value",value)
                    .text(value)); 
              });
            }
            else
            {
              alert(typeof data.shopArr);
              alert('nope');
            }
      })
// }
// else{ return false;}
})


/**
Запазване на информацията от формата и предаването на даните
*/

  // if($('#createTempRegister').valid() == true){
    $('#saveCart').click(function(e){
      e.preventDefault();
      var data_form = $('#createTempRegister').serialize();
        $.ajax({
          url: '/BuyItemsInCart/saveInformation/',
          method : 'POST',
          dataType: 'json',
          data: data_form,
        }).done(function(data){
          /**
          * Проверява дали формата е попълнена правилно
          * и тогава продължава с изпълнението на поръчката
          */
          if($('#createTempRegister').valid() == true){
              if(data.success == true){
                alert('поръчката завършена');
                window.location.href = "/books/page/33/1/2/title/asc";
              }else if(data.error == "Количката е празна" ){
                alert(data.error);
                window.location.href = "/books/page/33/1/2/title/asc";
              }
              else{
                alert(data.error);
              }
          }
          
        }).fail(function() {    
                    return false;
                });

    })
// }else{
  // return false;
// }


</script>

<?php $this->load->view('templates/footer');  ?>
