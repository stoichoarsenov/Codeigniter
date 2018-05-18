<?php $this->load->view('templates/header');?>


<!-- <section id="login"> -->
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12">
        	    <div class="form-wrap">
                <p style="font-size:25px;">Здравей <?=$currUserName?></p>
                <p style="text-align:center;"> Вашите адреси към момента: </p>
                <hr>
                <?php
foreach ($adress as $adress_item){
    // print_r($adress_item);
    echo ' <div class="col-xs-10">';
    echo 'Област '.$adress_item['AddrArea'].' ';
    echo 'Град '.$adress_item['AddrCity'].'  ';
    echo 'Квартал '.$adress_item['AddrNeibr'].' ';
    echo 'Адрес '.$adress_item['Addr'].' ';
    echo '</div>';
    if($adress_item['is_active'] == 1){
        echo '
        <button type="button" class="btn btn-default">
            <span class="glyphicon glyphicon-ok-sign" style="color:green; font-size:25px" aria-hidden="true"></span>
        </button>

        <button type="button" class="btn btn-default editAdress" data-toggle="modal" data-target="#myModal" data-id="'.$adress_item['id'].'" ">
            <span class="glyphicon glyphicon-edit" style="color:green; font-size:25px" aria-hidden="true"></span>
        </button>

        
        ';
    }else{ 
        echo '
        <button type="button" class="btn btn-default setAsACtive" data-id='.$adress_item['id'].'>
            <span class="glyphicon glyphicon-open " style="color:blue; font-size:25px" aria-hidden="true"></span>
        </button>
        

        <button type="button" class="btn btn-default editAdress" data-toggle="modal" data-target="#myModal" data-id="'.$adress_item['id'].'" ">
        <span class="glyphicon glyphicon-edit" style="color:green; font-size:25px" aria-hidden="true"></span>
        </button>

        <button type="button" class="btn btn-default deleteAdress" data-id="'.$adress_item['id'].'" ">
            <span class="glyphicon glyphicon-minus" style="color:red; font-size:25px" aria-hidden="true"></span>
        </button>
        ';

    }
    echo '<hr>';
    
} 
echo ' <div class="col-xs-12 col-lg-offset-5">
            <button type="button" class="btn btn-default editAdress" data-toggle="modal" data-target="#addAdressModal" ">
                Добави адрес <span class="glyphicon glyphicon-plus" style="color:green; font-size:25px" aria-hidden="true"></span>
            </button>
        </div>
';
?>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
<!-- </section> -->


<!-- Modal for edit adress -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                    <p style="text-align:center; font-size:20px;">Промени адреса</p>
            </div>

            <div class="modal-body" style="margin-bottom:20%">
                <form role="form" id ="changeAdress" action="user/adress">

                    <div class="form-row">   
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addrArea" name="addrArea" placeholder="Област">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addrCity" name="addrCity" placeholder="Град">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addrNeibr" name="addrNeibr" placeholder="Квартал">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="adress" name="adress" placeholder="Адрес">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                    <input type="submit" id="changeAdressSubmit" class="btn btn-success" value="Промени">
                    <a href="#" class="btn btn-danger" data-dismiss="modal">X</a>
            </div>
        </div>
    </div>
</div>


<!-- Modal for edit adress -->
<div id="addAdressModal" class="modal fade" role="dialog">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                    <p style="text-align:center; font-size:20px;">Добави нов адресс</p>
            </div>

            <div class="modal-body" style="margin-bottom:20%">
                <form role="form" id ="addAdress" action="/user/addAdres">

                    <div class="form-row">   
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addAddrArea" name="addAddrArea" placeholder="Област">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addAddrCity" name="addAddrCity" placeholder="Град">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addAddrNeibr" name="addAddrNeibr" placeholder="Квартал">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="addNewAdres" name="addNewAdres" placeholder="Адрес">
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="addAdressSubmit" class="btn btn-success" value="Добави">
                            <a href="#" class="btn btn-danger" data-dismiss="modal">X</a>
                    </div>
                </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>


<script>

$('#addAdressSubmit').click(function (e) {
    e.preventDefault();

        var data = {};
        var newArea = $('#addAddrArea').val();
        var newCity = $('#addAddrCity').val();
        var newNeibr = $('#addAddrNeibr').val();
        var newAadress = $('#addNewAdres').val();
        // console.log(info);

        // data:{username: username, password:password},
        data.newArea   = newArea;
        data.newCity   = newCity;
        data.newNeibr  = newNeibr;
        data.newAadress = newAadress;
            
    if($('#addAdress').valid() == true){
        $.ajax({
                url: '/user/addAdres',
                method: 'POST',          
                dataType: 'json',
                data: data,
            })
            
        .done(function(data){
            if(data.success == true){
                swal({title: "Успешно запазен", type: "success"}).then(function(){ 
                    location.reload();
                    });
                }
            else{
                swal({title: "неуспешно запазен", type: "fail"});
                }
            })
    }
});

$('.deleteAdress').click(function(e) {
    e.preventDefault()
    var address_id = $(this).attr('data-id');
    // console.log(address_id);
        $.ajax({
            url: '/user/deleteAdress/' + address_id,
            method: 'POST',          
            dataType: 'json',
            data: address_id,
        })
            .done(function(data) {
                if(data.success == true){
                    
                    swal({title: "Успешно изтрит", type: "success"}).then(function(){ 
                            location.reload();
                            }
                    );


                }
            })
});




$('.setAsACtive').click(function(e) {
    e.preventDefault()
     var address_id = $(this).attr('data-id');
        $.ajax({
            url: '/user/setActiveAdress/' + address_id,
            method: 'POST',          
            dataType: 'json',
            data: address_id,
        })
            .done(function(data) {
                // alert(data);
                if(data.success == true){
                    // swal("Запазено като активен", "" ,"success");
                    swal({title: "Запазено като активен", type: "success"}).then(function(){ 
                            location.reload();
                            }
                    );
                }
            })
});



$('#myModal').click(function (e) {
    var data = {};
    var id = $('.editAdress').data('id');
    var area = $('#addrArea').val();
    var city = $('#addrCity').val();
    var neibr = $('#addrNeibr').val();
    var adress = $('#adress').val();
    // console.log(info);
    data.id     =  id;
    data.area   = area;
    data.city   = city;
    data.neibr  = neibr;
    data.adress = adress;
        if($('#changeAdress').valid() == true){
    
            $.ajax({
                    url: '/user/changeAdress/',
                    method: 'POST',          
                    dataType: 'json',
                    data: data,
                })
                
                .done(function(data){
                    if(data.success == true){
                        location.reload(true);
                    }
                })

    }
});
</script>
