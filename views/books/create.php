
<?php $this->load->view('templates/header');  ?>


<?php 
$attributes = array('role'=>"form", 'id'=>"createBookForm");
echo form_open('books/create',$attributes); ?>
<div class="container">
  <div class="panel panel-default">
       <div class="panel-body">
       <div class="form-group">
            <div class="col-xl-2">  <label for="title">Title</label> <input type="text" name="title" id="title"  class="form-control title" /> </div>
            <p class="message"></p>
            <div class="col-xl-2">  <label for="author">Author</label> <input type="text" name="author" id="author" class="form-control"/> </div>
            <div class="col-xl-2">  <label for="description">Description</label> <input type="text" name="description" id="description" class="form-control"/> </div>
            <div class="col-xl-2">  <label for="price">Price</label>    <input type="text" name="price" id="price"  class="form-control"/> </div>

        <div class="col-xl-2">
        <label for="category" >Категория</label>
                    <select name="category"  class="form-control">
                            <?php foreach ($category['title'] as $category_item): ?>                      
                                        <option value="<?php echo $category_item['id']?>"><?php echo $category_item['title'];?></option>
                            <?php endforeach; ?>   
                    </select>
        </div>
        <div class="col-xl-2">
            <input style="margin-top:10px; margin-left:45%;" type="submit" class="btn btn-success"  name="submit" value="Create new book" />
                </div>
        </div>
    </div>   
   </div>

<?php echo form_close(); ?>


 
 <!-- title validation  -->
 <script type="text/javascript">    
        $('.title').on('blur', function() {
            var title = $(this).val();
            $.ajax({
                url: '/books/checkTitle/' + title,
                method: 'POST',
                dataType: 'json'
            }).done(function(data) {
                if (data.data !== "success"){
                        $('.message').text(data.data);
                        $("#title").removeClass('valid');
                        $("#title").addClass('error');
                        $("#createBookForm").submit(function(e){
                        return false;
                 });
                }
                else{
                        $('.message').text("");
                }
            }).fail(function() {    
                // alert(dat);
                // return false;
                console.log(data);
            });
        })
</script>

    
<?php $this->load->view('templates/footer');  ?>
