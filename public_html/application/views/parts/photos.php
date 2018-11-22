
<?php  if(!empty($data['part_data']['model_number'])){ ?>
<div class="col-lg-4 col-lg-offset-4">
<h2>Add Product Files</h2>

<div id="image_uploader">
    <ul id="part_photos">
      <?php
      
         foreach($data['photos'] as $photo){
         ?>
         <li class="thumbnail" alt="<?php echo $photo['id']; ?>">
         <i class="fa fa-close" onclick="delete_image(<?php echo $photo['id']; ?>);"></i>
            <?php if($photo['filetype'] == 'pdf'){ ?>
                <embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=<?php echo site_url(); ?>/<?php echo $photo['path']; ?>" width="125" height="95">
            <?php }else{ ?>
                <img src="<?php echo $photo['path']; ?>" />
            <?php } ?>
         </li>
        <?php
        }
       ?>
       <li class="thumbnail button"><div id="image-uploader"></div></li>
    </ul>
</div>
</div>
<?php  } ?>

