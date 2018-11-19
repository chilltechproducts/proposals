 
    <span class="alert-success"></span>
       <?php $array = $this->input->get(); ?>
       <div class="col-lg-4 col-lg-offset-4">
        <h2>View Parts</h2>
        <form id="registration_form" name="registration_form" action="javascript: part_submit();" class="search_parts">
              <!--  <div class="form-group">
                        <label>Part / Serial Number<span>req.</span></label>
                        <?php echo form_input(array('name'=>'serial_number', 'id'=> 'serial_number', 'placeholder'=>'Part / Serial Number', 'class'=>'form-control number', 'value'=> set_value('serial_number', $array['serial_number']))); ?>
                        <?php if (!empty($this->uri->segment(3))){ ?><img src="http://chilltech.ddns.net/QRCodeCreator/create/<?php echo $this->uri->segment(3); ?>" class="right inline qrcode" /> <?php } ?>
                        <?php echo form_error('serial_number');?>
                </div>-->
           </form>     
        </div>        
