 
    <span class="alert-success"></span>
       <?php $array = $this->input->get(); ?>
       <div class="col-lg-4 col-lg-offset-4">
        <h2>View Parts</h2>
        <form id="registration_form" name="registration_form" action="javascript: find_parts_json();" class="search_parts">
                <div class="form-group">
                        <label>Serial Number</label>
                        <?php echo form_input(array('name'=>'serial_number', 'id'=> 'serial_number', 'placeholder'=>'Part / Serial Number', 'class'=>'form-control name', 'value'=> set_value('serial_number', $array['serial_number']))); ?>
                       
                        <?php echo form_error('serial_number');?>
                </div>
                <div class="form-group">
                        <label>Model Number</label>
                        <?php echo form_input(array('name'=>'model_number', 'id'=> 'model_number', 'placeholder'=>'Model Number', 'class'=>'form-control name', 'value'=> set_value('model_number', $array['model_number']))); ?>
                       
                        <?php echo form_error('model_number');?>
                </div>
                <div class="form-group">
                        <label>Manufacturer</label>
                        <?php echo form_input(array('name'=>'manufacturer_name', 'id'=> 'manufacturer_name', 'placeholder'=>'Manufacturer', 'class'=>'form-control name', 'value'=> set_value('manufacturer_name', $array['manufacturer_name']))); ?>
                      
                        <?php echo form_error('manufacturer_name');?>
                </div>
                
                
                <div class="form-group">
                    <?php echo form_submit(array('value'=>'Search!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                </div>    
           </form>     
        </div>        
                                      
