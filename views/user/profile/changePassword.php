<?php $this->load->view('templates/header'); ?>

<section id="login">
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12">
        	    <div class="form-wrap">
                <h1>Смяна на парола</h1>
                    <?php
                    
                    $attributes = array('role'        =>    "form",
                                        'action'      =>    "javascript:;",
                                        'method'      =>    "post",
                                        'id'          =>    "resetPassword",
                                        'autocomplete'=>    "off");
                    echo form_open('user/changepassword', $attributes); ?>
                    
                    
                        <div class="form-group">
                            <label for="newPwd" class="sr-only">Въведете парола</label>
                            <input type="password" name="newPwd" id="newPwd" class="form-control" placeholder="Нова парола">
                        </div>
                        <div class="form-group">
                            <label for="newPwdConfirm" class="sr-only">Password</label>
                            <input type="password" name="newPwdConfirm" id="newPwdConfirm" class="form-control" placeholder="Повторете новата парола">
                        </div>
                        <div class="form-group">
                            <label for="pwd" class="sr-only">Password</label>
                            <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Старата парола">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="changePwdButton" class="btn btn-custom btn-lg btn-block" value="Смени паролата">
                    </form>
                    <hr>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<?php $this->load->view('templates/footer'); ?>
<script>
function showPassword() {
    
    var key_attr = $('#password').attr('type');
    
    if(key_attr != 'text') {
        
        $('.checkbox').addClass('show');
        $('#newPwd').attr('type', 'text');
        $('#newPwdConfirm').attr('type', 'text');
        $('#pwd').attr('type', 'text');
        
    } else {
        
        $('.checkbox').removeClass('show');
        $('#password').attr('type', 'password');
        
    }
    
}



$('#changePwdButton').click(function(e) {
    e.preventDefault()
    if($('#resetPassword').valid() == true){
    var changePwd = $('#resetPassword').serialize();
    // alert(login_form);         
        $.ajax({
            url: '/user/changePwd',
            method: 'POST',          
            dataType: 'json',
            data: changePwd,
        })
            .done(function(data) {
                // alert(data);
                if(data.success == true){
                    alert("Паролата успешно е сменена");
                    location.reload(true);
                }else{
                        alert(data.error);
                }
        
                
            }).fail(function() {
                alert('Упс нещо стана');
            });
        // }
        }
    })
</script>