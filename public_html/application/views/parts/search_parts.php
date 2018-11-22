 
    <span class="alert-success"></span>
       <?php $array = $this->input->get(); ?>
       <div class="col-lg-4 col-lg-offset-4">
        <h2>View Parts</h2>
        <form id="registration_form" name="registration_form" action="javascript: part_submit();" class="search_parts">
                <div class="form-group">
                        <label>Part / Serial Number</label>
                        <?php echo form_input(array('name'=>'serial_number', 'id'=> 'serial_number', 'placeholder'=>'Part / Serial Number', 'class'=>'form-control name', 'value'=> set_value('serial_number', $array['serial_number']))); ?>
                       
                        <?php echo form_error('serial_number');?>
                </div>
                <div class="form-group">
                        <label>Location Name</label>
                        <?php echo form_input(array('name'=>'location_name', 'id'=> 'location_name', 'placeholder'=>'Part Location', 'class'=>'form-control name', 'value'=> set_value('location_name', $array['location_name']))); ?>
                       
                        <?php echo form_error('location_name');?>
                </div>
                <div class="form-group">
                        <label>Manufacturer</label>
                        <?php echo form_input(array('name'=>'manufacturer_name', 'id'=> 'manufacturer_name', 'placeholder'=>'Manufacturer', 'class'=>'form-control name', 'value'=> set_value('manufacturer_name', $array['manufacturer_name']))); ?>
                      
                        <?php echo form_error('manufacturer_name');?>
                </div>
                <?php
                if($me['level_info']['user_level'] < 5) { ?>
                <div class="form-group">
                        <label>Customer</label>
                        <?php echo form_input(array('name'=>'customer_name', 'id'=> 'customer_name', 'placeholder'=>'Customer Name', 'class'=>'form-control name', 'value'=> set_value('customer_name', $array['customer_name']))); ?>
                      
                        <?php echo form_error('customer_name');?>
                </div>
                <?php } ?>
                <div class="form-group">
                        <label>Installer</label>
                        <?php echo form_input(array('name'=>'dealer_name', 'id'=> 'dealer_name', 'placeholder'=>'Installer', 'class'=>'form-control name', 'value'=> set_value('dealer_name', $array['dealer_name']))); ?>
                      
                        <?php echo form_error('dealer_name');?>
                </div>
                <div class="form-group">
                    <?php echo form_submit(array('value'=>'Search!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                </div>    
           </form>     
        </div>        
                                      
