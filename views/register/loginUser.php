<?php $this->load->view('templates/header');  ?>


<section id="login">
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12">
        	    <div class="form-wrap">
                <h1>Влезте с вашия емайл акаунт</h1>
                    <!-- <form role="form" action="javascript:;" method="post" id="login-form" autocomplete="off"> -->
                    <?php
                    
                    $attributes = array('role'        =>    "form",
                                        'action'      =>    "javascript:;",
                                        'method'      =>    "post",
                                        'id'          =>    "loginForm",
                                        'autocomplete'=>    "off");
                    echo form_open('user/login', $attributes); ?>
                    
                    
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="btnLogin" class="btn btn-custom btn-lg btn-block" value="Вход">
                    </form>
                    <!-- <a href="javascript:;" class="forget" data-toggle="modal" data-target=".forget-modal">Forgot your password?</a> -->
                    <!-- <hr> -->
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<!-- <div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Recovery password</h4>
			</div>
			<div class="modal-body">
				<p>Type your email account</p>
				<input type="email" name="recovery-email" id="recovery-email" class="form-control" autocomplete="off">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-custom">Recovery</button>
			</div>
		</div> 
	</div> 
</div>  -->


<script>

function showPassword() {
    
    var key_attr = $('#key').attr('type');
    
    if(key_attr != 'text') {
        
        $('.checkbox').addClass('show');
        $('#key').attr('type', 'text');
        
    } else {
        
        $('.checkbox').removeClass('show');
        $('#key').attr('type', 'password');
        
    }
    
}

$('#btnLogin').click(function(e) {
    e.preventDefault()
    var login_form = $('#loginForm').serialize();
    // alert(login_form);         
        $.ajax({
            url: '/user/loginUser',
            method: 'POST',          
            dataType: 'json',
            data: login_form,
        })
        //     .done(function(data) {
        //         if(data.success == true){
        //             alert('Успешно се регистрирахте');
        //         }
        
                
        //     }).fail(function() {
        //         alert('Упс нещо стана');
        //     });
        // }
    })


</script>


<?php $this->load->view('templates/footer');  ?>
