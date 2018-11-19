<form id="diagnostics_form" name="diagnostics_form" action="javascript: submit_diagnostics(<?php echo $this->uri->segment(3); ?>);">
  
                <div class="form-group">
                        <label>Service Date<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'service_date', 'id'=> 'service_date', 'placeholder'=>'Service Date', 'class'=>'form-control date', 'value'=> set_value('service_date', $array['service_date']?$array['service_date']:date('Y-m-d H:i')))); ?>
                        <?php echo form_error('service_date');?>
                </div>
                 <div class="form-group">
                        <label>Technician Name<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'technician_name', 'id'=> 'technician_name', 'placeholder'=>'Technician Name', 'class'=>'form-control name', 'value'=> set_value('technician_name', $array['technician_name']))); ?>
                        <input type="hidden" name="technician_id" value="<?php echo $arr['tech_id']; ?>" />
                        <?php echo form_error('technician_name');?>
                </div>
                <div class="form-group">
                        <label>Service Description<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_textarea(array('name'=>'service_performed', 'id'=> 'service_performed', 'placeholder'=>'Service Description', 'class'=>'form-control name', 'value'=> set_value('service_performed', $array['service_performed']))); ?>
                        <?php echo form_error('service_performed');?>
                </div>
                <div id="diagnostic_data">
                
                
                <div>

</form>
