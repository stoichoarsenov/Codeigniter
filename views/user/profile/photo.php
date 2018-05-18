<?php $this->load->view('templates/header');?>


<?php 



echo form_open_multipart('user/photo', array('class' => 'dropzone', 'id'=>"dropZone", 'method'=>"POST"));?>

    <div class="fallback">
        <input type="file" name="file"  multiple />
    </div>


    <div id="message" class="dz-message" data-dz-message><span>  
        <span  style="font-size:200px; width: 200;
                    display: block;
                    margin-left: auto;
                    margin-right: auto; " class="material-icons">cloud_upload</span>
                    <img data-dz-thumbnail /> </img>
    </div>



<?php
 echo form_close(); 
 ?> 



    <button type="submit" id="button"  style = "display: block; margin-left: auto; margin-right: auto; margin-top: 15px;" class="btn btn-primary">Submit</button>


<?php 
// var_dump($photos);
// if(!empty($photos)){
    foreach($photos as $photo){
        if($photo['is_active'] == 0){
    ?>
                    <div class="imageContainer" style="margin:3%;">
                        <img src="/assets/images/<?=$userId?>/<?=$photo['cropped_photo']; ?>" width="250px;" height = "250px" alt="Avatar" class="image">
                            <div class="middle">    
                                <button class="btn btn-success setAsActive"  name="buttonActivePhoto" data-value=<?=$photo['id']?>><span style="font-size: 25px;" class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
                                <button class="btn btn-danger deletePhoto" name="buttonInActivePhoto" data-value=<?=$photo['id']?>><span style="font-size: 25px;" class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
                            </div>
                    </div>
    <?php   
    }else{
    ?>
                    <div class="imageContainer" style="margin:3%;">
                        <img src="/assets/images/<?=$userId?>/<?=$photo['cropped_photo']; ?>" width="250px;" height = "250px"  class="image">
                            <div class="middle">
                                <text>active</text>
                            </div>
                    </div>
    <?php
        }
    }
// }
//$this->load->view('templates/footer'); ?>

<script>
Dropzone.options.dropZone = {
  url: this.location,
    paramName: "file", //the parameter name containing the uploaded file
    maxFilesize: 2, //in mb
    uploadMultiple: false, 
    maxFiles: 1, // allowing any more than this will stress a basic php/mysql stack
    addRemoveLinks: false,
    acceptedFiles: '.png,.jpg,.gif', //allowed filetypes
    autoProcessQueue: false,  
  
  init: function() {
    
    var myDropzone = this;

            $("#button").click(function (e) {
                e.preventDefault();
                myDropzone.processQueue();
            });

     this.on('sending', function(file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropZone').serializeArray();
            $.each(data, function(key, el) {
                formData.append(el.name, el.value);
            });

    });
    this.on("success", function(file, responseText) {
        swal({title: "Успешно запазен", type: "success"}).then(function(){ 
                    location.reload();
                    });
    });
    this.on("addedfile", function(file){
  		// alert('hi');
  	});
  }
};


$('.deletePhoto').click(function (e) {
    e.preventDefault();
    var id = $(this).data().value; 

    console.log(id);
        $.ajax({
                url: '/user/deletePhoto',
                method: 'POST',          
                dataType: 'json',
                data: {id},
            })

            
        .done(function(data){
            if(data.success == true){
                swal({title: "Изтрихте оказаната снимка", type: "success"}).then(function(){ 
                    location.reload();
                    });
                }
            else{
                swal({title: "неуспешно запазен", type: "fail"});
                }
            })
});


$('.setAsActive').click(function (e) {
    e.preventDefault();
    var id = $(this).data().value; 

    console.log(id);
        $.ajax({
                url: '/user/setAsActivePhoto',
                method: 'POST',          
                dataType: 'json',
                data: {id},
            })

            
        .done(function(data){
            if(data.success == true){
                swal({title: "Снимката е активна", type: "success"}).then(function(){ 
                    location.reload();
                    });
                }
            else{
                swal({title: "ууупс", type: "fail"});
                }
            })
});


</script>