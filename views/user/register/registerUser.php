<?php $this->load->view('templates/header');  ?>


<div class="container">
<?php
$attributes = array('role'=>"form", 
                    'id'=>"registerUser",
                     'autocomplete'=>"off");
                     
echo form_open('user/registerUser', $attributes); ?>

    
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="username">Име</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Въведете име">
        </div>
        
        <div class="form-group col-md-6">
            <label for="userFamName">Фамилия</label>
            <input type="text" class="form-control" id="userFamName" name="userFamName" placeholder="Въведете Фамилия">
        </div>
    </div>

    <div class="form-row" >
        <div class="form-group col-md-6">
            <label for="registerPassword">Парола</label>
            <input type="password" class="form-control" id="registerPassword" name="registerPassword" placeholder="Парола">
        </div>

        <div class="form-group col-md-6">
            <label for="passwordCheck">Потвърдете парола</label>
            <input type="password" class="form-control" id="passwordCheck" name="passwordCheck" placeholder="Потвърдете парола">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="addrArea">Област</label>
            <input type="text" class="form-control" id="addrArea" name="addrArea" placeholder="Област">
        </div>

        <div class="form-group col-md-3">
            <label for="addrCity">Град</label>
            <input type="text" class="form-control" id="addrCity" name="addrCity" placeholder="Град">
        </div>

        <div class="form-group col-md-3">
            <label for="addrNeibr">Квартал</label>
            <input type="text" class="form-control" id="addrNeibr" name="addrNeibr" placeholder="Квартал">
        </div>

        <div class="form-group col-md-3">
            <label for="addr">Адрес</label>
            <input type="text" class="form-control" id="adress" name="adress" placeholder="Адрес">
        </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="phoneNumber">Телефонен номер</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Телефонен номер">
        </div>

        <div class="form-group col-md-6">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="Email" name="Email" placeholder="Email">
            <div id="mailError"></div>
        </div>
    </div>
    
    <div class="form-row">
            <div  name="CaptchaCode" id="capatcha">
            <div class="g-recaptcha" data-callback="recaptchaCallback" style=" display: inline-block;" data-sitekey="6LcmqFgUAAAAABs4CXeDUOVtpHbUSz8Uj8DDKz8o"></div>
            <label id="hiddenRecaptcha-error" class="error" for="hiddenRecaptcha">Полето е задължително</label>
            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">

        </div>
    </div>
    
    <div class="form-row" style="padding-top:25px;">
        <input type="submit" id="registerUserSubmit" disabled="" class="btn btn-success center-block" value="Регистрирай се">
    </div> 

<?php echo form_close(); ?>

</div>

<script type="text/javascript">
 
function  recaptchaCallback(){
    //   alert("callback working");
      $('#hiddenRecaptcha-error').hide();
      $('#registerUserSubmit').prop("disabled", false);
}

// function recaptchaCallback() {
    // $('#hiddenRecaptcha-error').hide();
    // };  

$('#Email').change(function(e){
        e.preventDefault()
        var email = $(this).val();
        $.ajax({
            url: '/user/checkMail/' + email,
            method: 'POST',          
            dataType: 'json',
            data: email,
        }).done(function(data) {
            if(data.success == false){
                swal({title: "Мейлът е зает", type: "error"});
                $("#Email").val("Емайлът е зает");
                $("#Email" ).addClass( "form-control error" );
            }
        })
    });

$('#registerUserSubmit').click(function(e) {
        e.preventDefault()
        setTimeout(function() {
        if(($('#registerUser').valid() == true) && ($('#Email').valid() == true)) {
        
        var data_form = $('#registerUser').serialize();
        
        $.ajax({
            url: '/user/registerNewUser',
            method: 'POST',          
            dataType: 'json',
            data: data_form,
        })
            .done(function(data) {
                if(data.success == true){
                    swal({title: "Успешно се регистрирахте", type: "success"});
                   setTimeout(function () {
                    window.location.href = "/user/login";
                                }, 3000);
                    
                }  
            }).fail(function() {
                alert('Упс нещо стана');
            });
        }
    },200);
});

</script>






<?php $this->load->view('templates/footer');  ?>
