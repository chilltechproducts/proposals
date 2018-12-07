 
    <span class="alert-success"></span>
       <?php $array = $this->input->get(); ?>
       <div class="col-lg-4 col-lg-offset-4">
        <h2>View Clients</h2>
        <form id="registration_form" name="registration_form" action="javascript: find_clients();" class="search_parts">
              
                <div class="form-group">
                        <label>Name, Company Name or Email</label>
                        <?php echo form_input(array('name'=>'company_name', 'autocomplete' => 'off', 'id'=> 'company_name', 'placeholder'=>'Name, Company Name or Email', 'class'=>'form-control name', 'value'=> set_value('company_name', $array['company_name']))); ?>
                       
                        <?php echo form_error('company_name');?>
                </div>
               
                
                
                <div class="form-group">
                    <?php echo form_submit(array('value'=>'Search!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                </div>    
           </form>     
        </div>        
                                      
