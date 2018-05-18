<?php $this->load->view('templates/header');  ?>

<?php                    
$attributes = array('role'        =>    "form",
                    'action'      =>    "javascript:;",
                    'method'      =>    "post",
                    'id'          =>    "changeProfileInfo",
                    'class'       =>    "form-horizontal");

echo form_open('user/info', $attributes); ?>


    <div class="form-group">
        <label class="col-lg-3 control-label">Име</label>
            <div class="col-lg-7">
                <input class="form-control" type="text" name="username"  placeholder="<?=$userinfo['username']?>">
            </div>
    </div>



    <div class="form-group">
        <label class="col-lg-3 control-label">Фамилия</label>
            <div class="col-lg-7">
                <input class="form-control" type="text" name="userFamName"  placeholder="<?=$userinfo['usrFamName']?>">
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-3 control-label">Телефонен номер:</label>
            <div class="col-lg-7">
                <input class="form-control" type="text" name="phoneNumber"  placeholder="<?=$userinfo['phoneNumber']?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-3 control-label">Мейл:</label>
            <div class="col-lg-7">
                <input class="form-control" type="text" id="Email" name="Email" placeholder="<?=$userinfo['email']?>">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-3 control-label"></label>
                <div class="col-md-7">
                    <input type="button" id="changeInfo" class="btn btn-primary" value="Запази промените">
                    <span></span>
        </div>
    </div>


<?=form_close()?>


<?php $this->load->view('templates/footer');  ?>


<script>

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

$('#changeInfo').click(function(e) {
    e.preventDefault()
    var email = $(this).val();
    setTimeout(function() {

    if($('#changeProfileInfo').valid() == true){
    var info = $('#changeProfileInfo').serializeArray();    
        $.ajax({
            url: '/user/changeInfo',
            method: 'POST',          
            dataType: 'json',
            data: {info},
        })
            .done(function(data) {
                if(data.success == true){
                    swal({title: "Успешно подновихте данните си", type: "success"});
                    location.reload(true);
                }else{
                        alert(data.error);
                }
        
                
            }).fail(function() {
                alert('Упс нещо стана');
            });
        }
    },200);});

</script>