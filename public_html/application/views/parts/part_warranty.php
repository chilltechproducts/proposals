<div class="col-lg-4 col-lg-offset-4">
        <h2>Product / Part Warranty</h2> 
        <?php $array = $data['part_warranty']; ?>
         <div class="form-group">
                        <label>Length of Warranty (Years)<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'length_of_part_warranty', 'id'=> 'length_of_part_warranty', 'placeholder'=>'Length of Warranty (Years)', 'class'=>'form-control name', 'value'=> set_value('length_of_part_warranty', $array['length_of_part_warranty']))); ?>
                        <?php echo form_error('length_of_part_warranty');?>
         </div>
         <div class="form-group">
                        <label>Warranty Description<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_textarea(array('name'=>'part_warranty_text', 'id'=> 'part_warranty_text', 'placeholder'=>'Warranty Description', 'class'=>'form-control name', 'value'=> set_value('part_warranty_text', $array['part_warranty_text']))); ?>
                        <?php echo form_error('part_warranty_text');?>
         </div>
         <?php if(!empty($this->uri->segment(3))){ 
                    //put remaining time here 
                 } 
          ?>
          
            <?php echo form_submit(array('value'=>$submit_label, 'class'=>'btn btn-lg btn-primary btn-block', 'id' => 'id_submit_form')); ?>
</div>
<script>
CKEDITOR.replace( 'part_warranty_text' ) 
</script>
