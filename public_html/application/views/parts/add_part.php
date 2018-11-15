
 
    
    <span class="alert-success"></span>
       <?php $array = $data['part_data']; ?>
       <div class="col-lg-4 col-lg-offset-4">
        <h2>Add / Edit Part</h2>
        <form id="registration_form" name="registration_form" action="javascript: part_submit();" >
                <div class="form-group">
                        <label>Part / Serial Number<span>req.</span></label>
                        <?php echo form_input(array('name'=>'part_serial_number', 'id'=> 'part_serial_number', 'placeholder'=>'Part / Serial Number', 'class'=>'form-control number', 'value'=> set_value('part_serial_number', $array['part_serial_number']))); ?>
                        <?php if (!empty($this->uri->segment(3))){ ?><img src="http://chilltech.ddns.net/QRCodeCreator/create/<?php echo $this->uri->segment(3); ?>" class="right inline qrcode" /> <?php } ?>
                        <?php echo form_error('part_serial_number');?>
                </div>
                <div class="form-group">
                        <label>Model Number<span>req.</span></label>
                        <?php echo form_input(array('name'=>'model_number', 'id'=> 'model_number', 'placeholder'=>'Model Number', 'class'=>'form-control number', 'value'=> set_value('model_number', $array['model_number']))); ?>
                        <?php echo form_error('model_number');?>
                </div>
                <div class="form-group">
                        <label>SKU Number<span>opt.</span></label>
                        <?php echo form_input(array('name'=>'sku_number', 'id'=> 'sku_number', 'placeholder'=>'SKU Number', 'class'=>'form-control number', 'value'=> set_value('sku_number', $array['sku_number']))); ?>
                        <?php echo form_error('sku_number');?>
                </div>
                <div class="form-group">
                        <label>UPC Number<span>opt.</span></label>
                        <?php echo form_input(array('name'=>'upc_number', 'id'=> 'upc_number', 'placeholder'=>'UPC Number', 'class'=>'form-control number', 'value'=> set_value('upc_number', $array['upc_number']))); ?>
                        <?php echo form_error('upc_number');?>
                </div>
                <div class="form-group">
                        <label>Model Number<span>req.</span></label>
                        <?php echo form_input(array('name'=>'model_number', 'id'=> 'model_number', 'placeholder'=>'Model Number', 'class'=>'form-control number', 'value'=> set_value('model_number', $array['model_number']))); ?>
                        <?php echo form_error('model_number');?>
                </div>
                <div class="form-group">
                        <label>Manufacturer Name<span>req.</span></label>
                        <?php echo form_input(array('name'=>'manufacturer_name', 'id'=> 'manufacturer_name', 'placeholder'=>'Manufacturer Name', 'class'=>'form-control name', 'value'=> set_value('manufacturer_name', $array['manufacturer_name']))); ?>
                        <?php echo form_error('manufacturer_name');?>
                </div>
                <div class="form-group">
                        <label>Location Name<span>req.</span></label>
                        <?php echo form_input(array('name'=>'location_name', 'id'=> 'location_name', 'placeholder'=>'Location Name', 'class'=>'form-control name', 'value'=> set_value('location_name', $array['location_name']))); ?>
                        <?php echo form_error('location_name');?>
                </div>
                
                <div class="form-group">
                        <label>Dealer Name<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'dealer_name', 'id'=> 'dealer_name', 'placeholder'=>'Dealer Name', 'class'=>'form-control name', 'value'=> set_value('dealer_name', $array['dealer_name']))); ?>
                        <?php echo form_error('dealer_name');?>
                </div>
                <div class="form-group">
                        <label>End User Name<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'customer_name', 'id'=> 'customer_name', 'placeholder'=>'End User Name', 'class'=>'form-control name', 'value'=> set_value('customer_name', $array['customer_name']))); ?>
                        <?php echo form_error('customer_name');?>
                </div>
                <div class="form-group">
                        <label>Salesman Name<span>opt.</span></label>
                        <?php echo form_input(array('name'=>'salesman_name', 'id'=> 'salesman_name', 'placeholder'=>'Salesman Name', 'class'=>'form-control name', 'value'=> set_value('salesman_name', $array['salesman_name']))); ?>
                        <?php echo form_error('salesman_name');?>
                </div>
                <div class="form-group">
                        <label>Installer Name<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'installer_name', 'id'=> 'installer_name', 'placeholder'=>'Installer Name', 'class'=>'form-control name', 'value'=> set_value('installer_name', $array['installer_name']))); ?>
                        <?php echo form_error('installer_name');?>
                </div>
                <div class="form-group">
                        <label>Install Date<span><?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){?>req.<?php }else{?>opt.<?php }?></span></label>
                        <?php echo form_input(array('name'=>'install_date', 'id'=> 'install_date', 'placeholder'=>'Install Date', 'class'=>'form-control date', 'value'=> set_value('install_date', $array['install_date']?$array['install_date']:date('Y-m-d H:i')))); ?>
                        <?php echo form_error('install_date');?>
                </div>
                <div class="form-group">
                        <label>Last Service Date<span>opt.</span></label>
                        <?php echo form_input(array('name'=>'last_service_date', 'id'=> 'last_service_date', 'placeholder'=>'Last Service Date', 'class'=>'form-control date', 'value'=> set_value('last_service_date', $array['last_service_date']?$array['last_service_date']:date('Y-m-d H:i')))); ?>
                        <?php echo form_error('last_service_date');?>
                </div>
      
            </div>     
<script>
$('.date').datetimepicker({
formatDate:'Y/m/d H:i',
 minDate:'-1970/01/02',//yesterday is minimum date(for today use 0 or -1970/01/01)
 maxDate:'+1970/01/02',//tomorrow is maximum date calendar
 mask:true
 
 });
 </script>
					
