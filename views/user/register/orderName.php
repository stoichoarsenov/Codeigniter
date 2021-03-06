﻿<?php $this->load->view('templates/header');  

// value na phonenumber
// var_dump($adress);
if($isLogged == true){
  $name = 'value="'.$userInfo[0]["username"].'", disabled="disabled"';
  $familyName = 'value="'.$userInfo[0]["usrFamName"].'", disabled="disabled"';
  $email = 'value="'.$userInfo[0]["email"].'", disabled="disabled"';
  $chooseCity = $adress;
  $chooseOffice = $office;
  $phoneNumber = 'value="'.$userInfo[0]["phoneNumber"].'", disabled="disabled"';
  $adress  = 'value="'.$adress.'", disabled="disabled"';
  $city = 'value="'.$city.'", disabled="disabled"';
  $office = 'value="'.$office.'", disabled="disabled"';
  
}else{
$name = '';
$familyName = '';
$email = '';
$chooseCity = '';
$chooseOffice = '';
$phoneNumber = 'value = "+359 "';
$adress  = '';
$city = '';
$office = '';
}


?>

<?php 

$attributes = array('role'=>"form", 'id'=>"createTempRegister");
echo form_open('register/orderName', $attributes); 

?>

<div class="container">
  <div class="form-row">
    <div class="form-group">
      <label for="name">Име</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Име" <?=$name?>>
    </div>


    <div class="form-group">
      <label for="familyName">Фамилия</label>
      <input type="text" class="form-control" name="familyName" id="familyName" placeholder="Фамилия" <?=$familyName?> >
    </div>


    <div class="form-group">
      <label for="Email">Email</label>
      <input type="text" class="form-control" name="txtEmail" id="txtEmail" placeholder="Email" <?=$email?> >
    </div>


    <div class="form-group">
      <label for="number">Номер</label>
      <!-- <div class="input-group"> -->
        <!-- <span class="input-group-addon" id="basic-addon1">+359</span> -->
        <input type="text" class="form-control" name="number" <?=$phoneNumber?>  id="number">
      <!-- </div> -->
    </div>


    <div class="form-group">
      <label for="adress">Адрес</label>
      <input  <?=$adress?> type="text" class="form-control" name="adress" id="adress" placeholder="Адрес">
    </div>


    <div class="form-group col-md-6">
      <label for="city">Град</label>
        <select  <?=$city?> name="chooseCity" id="chooseCity" class="form-control">
          <option value="choose"  disabled selected> <?=$chooseCity?></option>
          <option value="Sofia">София</option>
          <option value="Burgas">Бургас</option>
          <option value="Varna">Варна</option>
          <option value="StaraZagora">Стара загора</option>
        </select>
    </div>
    
    <div name="chooseCity" id="chooseCity" class="form-group col-md-6">
      <label <?=$office?> for="Office">Офис</label>
      <select name="selectOffice" id="selectOffice" class="form-control" disabled="disabled">
      <option value="choose"  disabled selected> <?=$chooseOffice?></option>
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
              window.location.href = "http://www.test.com:8080/books/page/33/1/2/title/asc";
          }
          else{
            window.location.href = "http://www.test.com:8080/books/page/33/1/2/title/asc";
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
                   swal({title: "поръчката завършена", type: "success"});
                   setTimeout(function () {
                             window.location.href = "http://www.test.com:8080/books/page/33/1/2/title/asc";
                                }, 3000);
              }else if(data.error == "Количката е празна" ){
                  swal({title: data.error, type: "error"});
                  setTimeout(function () {
                             window.location.href = "http://www.test.com:8080/books/page/33/1/2/title/asc";
                                }, 3000);
              }
              else{
                swal({title: data.error, type: "error"});
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
