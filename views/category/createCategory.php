
<?php echo form_open('category/createCategory'); ?>
<?php echo validation_errors(); ?>

<div class="container">
            <div class="row">
            <div class="col-sm-3">  <label for="prio">Prio</label> <input type="number" name="Prio" /> </div>
            <div class="col-sm-3">  <label for="title">Title</label> <input type="text" name="Title"/> </div>
            <div class="col-sm-3">  <label for="keyword">Keyword</label> <input type="text" name="Keyword"/> </div>


    <div class="col-sm-3"><input type="submit" name="submit" value="Create new category" /></div>
    </div>
</form>