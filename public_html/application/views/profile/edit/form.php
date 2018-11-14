<div class="col-lg-4 col-lg-offset-4">
    <h2><?php if(!empty($data['user_id'])){ ?>Edit <?php if($data['user_id'] == $this->session->userdata['user_id']){ ?>Your<?php }else{ echo $data['first_name'] . ' ' . $data['last_name'] . '\'s'; } ?> Profile <?php }else{ ?>Add a User<?php } ?></h2>
    <span class="alert-success"></span>
    
    <?php echo form_open_multipart('upload_controller/do_upload');?>
        <div class="form-group">
            <label>User Avatar<span>opt.</span></label> 
                
                <?php echo "<input type='file' name='userfile' size='20' />"; ?>
            </div>
    <?php echo "</form>"?>
    <?php echo form_open_multipart('upload_controller/do_upload');?>
        <div class="form-group">
            <label>Company Logo<span>opt.</span></label> 
                
                <?php echo "<input type='file' name='logo' size='20' />"; ?>
            </div>
    <?php echo "</form>"?>
    <form id="registration_form" name="registration_form" action="javascript: get_form_data_and_submit();" >
         <?php if($this->session->userdata['user_id'] == $this->input->get('user_id')){ $array = $me; } else { if($me['level_info']['level_id'] <=2){ $array = $data;  }else{ $array = $this->input->post(); } } ?>
    <div class="form-group">
      <label>Email</label>
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'disabled' => true,
          'value'=> set_value('email', $array['email']))); ?>
      <?php echo form_error('email') ?>
    </div>
        
            <div class="form-group">
                <label>First Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'first_name', 'id'=> 'first_name', 'placeholder'=>'First Name', 'class'=>'form-control', 'value' => set_value('first_name', $array['first_name'])  )   ); ?>
                <?php echo form_error('firstname');?>
            </div>
            <div class="form-group">
                <label>Last Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'last_name', 'id'=> 'last_name', 'placeholder'=>'Last Name', 'class'=>'form-control', 'value'=> set_value('last_name', $array['last_name']))); ?>
                <?php echo form_error('lastname');?>
            </div>
             <div class="form-group">
                <label>Address<span>req.</span></label>
                <?php echo form_input(array('name'=>'street_address', 'id'=> 'street_address', 'placeholder'=>'Street Address', 'class'=>'form-control', 'value'=> set_value('street_address', $array['street_address']))); ?>
                <?php echo form_error('street_address');?>
            </div>
             <div class="form-group">
                <label>Apt/Unit<span>opt.</span></label>
                <?php echo form_input(array('name'=>'street_address2', 'id'=> 'street_address2', 'placeholder'=>'Apt / Unit', 'class'=>'form-control', 'value'=> set_value('street_address2', $array['street_address2']))); ?>
                <?php echo form_error('street_address2');?>
            </div>
             <div class="form-group">
                <label>City<span>req.</span></label>
                <?php echo form_input(array('name'=>'city', 'id'=> 'city', 'placeholder'=>'City', 'class'=>'form-control', 'value'=> set_value('city', $array['city']))); ?>
                <?php echo form_error('city');?>
            </div>
             <div class="form-group">
                <label>State<span>req.</span></label>
          
                <?php echo form_dropdown(
                                                  array( 'id' => 'state', 'name' => 'state', 'class' => 'form-control', 'options' => $states )
                                                 )
                                    ?>    
                <?php echo form_error('state');?>
            </div>
             <div class="form-group">
                <label>Zip Code<span>req.</span></label>
                <?php echo form_input(array('name'=>'postal_code', 'id'=> 'postal_code', 'placeholder'=>'Zip Code', 'class'=>'form-control', 'value'=> set_value('postal_code', $array['postal_code']))); ?>
                <?php echo form_error('postal_code');?>
            </div>
             <div class="form-group">
                <label>Service Phone <span>opt.</span></label>
            
            service_phone                | varchar(200) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Sales Phone<span>opt.</span></label>
| sales_phone                  | varchar(200) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Emergency Phone<span>opt.</span></label>
| emergency_phone              | varchar(200) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Fax<span>opt.</span></label>
| fax_phone                    | varchar(200) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>EIN<span>opt.</span></label>
| employer_identication_number | varchar(200) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Webhook URL<span>opt.</span></label>
| webhook_url                  | varchar(400) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Website URL<span>opt.</span></label>
| user_website                 | varchar(300) | YES  |     | NULL    |                |
            </div>
             <div class="form-group">
                <label>Facebook URL<span>opt.</span></label>
| user_facebook                | varchar(300) | YES  |     | NULL
            </div>
    
             <?php 
      $levels = array();
      foreach($user_levels as $key => $arr){
         $levels[$arr->level_id] = $arr->level_name;
      
      }
      if($this->session->userdata['user_id'] != $data['user_id']
            & 
            ($me['level_id'] <=2 | $me['level_id'] == 5 | $me['level_id'] == 8)){
               
                        ?>
                                <div class="form-group">
                                <label>User Level</label>
                                    <?php echo form_dropdown(
                                                  array( 'id' => 'level_id', 'name' => 'level_id', 'class' => 'form-control', 'options' => $levels )
                                                 )
                                    ?>             
                                </div>
                                <div class="form-group">
                    
                                </div>
                                <div class="form-group">
                    
                                </div>
                                <div class="form-group">
                    
                                </div>
            <?php
                     
           
                }  
            ?>
          <?php echo form_input(array('type' => 'hidden', 'name' => 'user_id', 'id' => 'user_id')); ?>
        
    
    <?php echo form_submit(array('value'=>'Add User Access!', 'class'=>'btn btn-lg btn-primary btn-block', 'id' => 'id_submit_form')); ?>
    <?php echo form_close(); ?>
   
</div>
 
