<?php 
// echo $exactBooks['object_id'];

foreach ($exactBooks as $exactBooks_item): ?>
                <div class="col-sm-4" style="padding-bottom: 50px;"> <?php echo($exactBooks_item['title']); ?> </div>
                <div class="col-sm-4" style="padding-bottom: 50px;"> <?php echo($exactBooks_item['author']); ?></div>
                <div class="col-sm-4" style="padding-bottom: 50px;"> <?php echo($exactBooks_item['description']); ?></div>
                
                </div>
<?php endforeach; ?> 