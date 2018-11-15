<div class="col-lg-4 col-lg-offset-4">
  <?php if($this->session->userdata['user_id'] == $this->input->get('user_id')){ $array = $me; } else { if($me['level_info']['level_id'] <=2){ $array = $data;  }else{ $array = $this->input->post(); } } ?>
    <h2><?php if(!empty($data['user_id'])){ ?>Edit <?php if($data['user_id'] == $this->session->userdata['user_id']){ ?>Your<?php }else{ echo $data['first_name'] . ' ' . $data['last_name'] . '\'s'; } ?> Profile <?php }else{ ?>Add a User<?php } ?></h2>
    <span class="alert-success"></span>
   
        <div class="form-group">
            <label>User Avatar<span>opt.</span></label> 
                <div id="preview-avatar"><?php if(!empty($array['avatar'])){ ?><img src="<?php echo $array['avatar']; ?>" /><?php } ?></div>
                <div id="avatar-uploader"></div>
        </div>
    
   
        <div class="form-group">
            <label>Company Logo<span>opt.</span></label> 
                <div id="preview-logo"><?php if(!empty($array['logo'])){ ?><img src="<?php echo $array['logo']; ?>" /><?php } ?></div>
                <div id="logo-uploader"></div>
        </div>
    
    <form id="registration_form" name="registration_form" action="javascript: get_form_data_and_submit();" >
    <?php if($array['level_id'] <= 2){ ?>
    <div class="form-group">
                <label>Company Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'company_name', 'id'=> 'company_name', 'placeholder'=>'Company Name', 'class'=>'form-control', 'value' => set_value('company_name', $array['company_name']?$array['company_name']:$array['first_name'] . ' ' . $array['last_name'] )  )   ); ?>
                <?php echo form_error('first_name');?>
            </div>
    
    <?php } ?>
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
                <?php echo form_error('first_name');?>
            </div>
            <div class="form-group">
                <label>Last Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'last_name', 'id'=> 'last_name', 'placeholder'=>'Last Name', 'class'=>'form-control', 'value'=> set_value('last_name', $array['last_name']))); ?>
                <?php echo form_error('last_name');?>
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
                <?php echo form_input(array('name'=>'city', 'id'=> 'city', 'placeholder'=>'City', 'class'=>'form-control', 'autocomplete' => 'off', 'value'=> set_value('city', $array['city']))); ?>
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
                <?php echo form_input(array('name'=>'postal_code', 'id'=> 'postal_code', 'placeholder'=>'Zip Code', 'class'=>'form-control', 'autocomplete' => 'off', 'value'=> set_value('postal_code', $array['postal_code']))); ?>
                <?php echo form_error('postal_code');?>
            </div>
            <div class="form-group">
                <label>Primary Phone <span>req.</span></label>
                <?php echo form_input(array('name'=>'business_phone', 'id'=> 'business_phone', 'class'=>'form-control', 'autocomplete' => 'off', 'data-masked-input' => '(999) 999-9999', 'placeholder' => 'Primary Phone', 'value'=> set_value('business_phone', $array['business_phone']))); ?>
                <?php echo form_error('business_phone');?>
           
            </div>
            <div class="form-group">
                <label>Service Phone <span>opt.</span></label>
                <?php echo form_input(array('name'=>'service_phone', 'id'=> 'service_phone',  'class'=>'form-control', 'autocomplete' => 'off', 'data-masked-input' => '(999) 999-9999', 'placeholder' => 'Service Phone', 'value'=> set_value('service_phone', $array['service_phone']))); ?>
                <?php echo form_error('service_phone');?>
           
            </div>
            <div class="form-group">
                <label>Sales Phone <span>opt.</span></label>
                <?php echo form_input(array('name'=>'sales_phone', 'id'=> 'sales_phone',  'class'=>'form-control', 'autocomplete' => 'off', 'data-masked-input' => '(999) 999-9999', 'placeholder' => 'Sales Phone', 'value'=> set_value('sales_phone', $array['sales_phone']))); ?>
                <?php echo form_error('sales_phone');?>
           
            </div>
             <div class="form-group">
                <label>Emergency Phone <span>opt.</span></label>
                <?php echo form_input(array('name'=>'emergency_phone', 'id'=> 'emergency_phone',  'class'=>'form-control', 'autocomplete' => 'off', 'data-masked-input' => '(999) 999-9999', 'placeholder' => 'Emergency Phone', 'value'=> set_value('emergency_phone', $array['emergency_phone']))); ?>
                <?php echo form_error('emergency_phone');?>
           
            </div>
            <div class="form-group">
                <label>Fax Phone <span>opt.</span></label>
                <?php echo form_input(array('name'=>'fax_phone', 'id'=> 'fax_phone',  'class'=>'form-control', 'autocomplete' => 'off', 'data-masked-input' => '(999) 999-9999', 'placeholder' => 'fax',  'value'=> set_value('fax_phone', $array['fax_phone']))); ?>
                <?php echo form_error('fax_phone');?>
           
            </div>
             <div class="form-group">
                <label>EIN<span>opt.</span></label>
                <?php echo form_input(array('name'=>'employer_identication_number', 'id'=> 'employer_identication_number', 'placeholder'=>'Employer Identification Number', 'class'=>'form-control', 'value' => set_value('employer_identication_number', $array['employer_identication_number'])  )   ); ?>
                <?php echo form_error('employer_identication_number');?>
            </div>
             <div class="form-group">
                <label>Webhook URL<span>opt.</span></label>
                <?php echo form_input(array('name'=>'webhook_url', 'id'=> 'webhook_url', 'placeholder'=>'Webhook / Callback URL', 'class'=>'form-control', 'value' => set_value('webhook_url', $array['webhook_url'])  )   ); ?>
                <?php echo form_error('webhook_url');?>
            </div>
             <div class="form-group">
                <label>Website URL<span>opt.</span></label>
                <?php echo form_input(array('name'=>'user_website', 'id'=> 'user_website', 'placeholder'=>'Website URL', 'class'=>'form-control', 'value' => set_value('user_website', $array['user_website'])  )   ); ?>
                <?php echo form_error('user_website');?>
            </div>
             <div class="form-group">
                <label>Facebook URL<span>opt.</span></label>
                <?php echo form_input(array('name'=>'user_facebook', 'id'=> 'user_facebook', 'placeholder'=>'Facebook URL', 'class'=>'form-control', 'value' => set_value('user_facebook', $array['user_facebook'])  )   ); ?>
                <?php echo form_error('user_facebook');?>
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
        
    <?php if(!empty($array['user_id'])){ if($array['user_id'] == $this->session->userdata['user_id']){ $submit_label = 'Edit My Account'; }else{ $submit_label = 'Edit User Account'; } }else{ $submit_label='Add User Access!'; } ?>
    <?php echo form_submit(array('value'=>$submit_label, 'class'=>'btn btn-lg btn-primary btn-block', 'id' => 'id_submit_form')); ?>
    <?php echo form_close(); ?>
   
</div>
 
<script>
$('#postal_code').click(function(){
								      $('#postal_code').autocomplete({
											    minLength: 1,
											    source: '/ajax/zipcodes/?q=' + $(this).val(),
											    focus: function( event, ui ) {
                                                  
												return false;
											    },
											    select: function( event, ui ) {
												  $( '#city' ).val( ui.item.city );
												  $( '#state' ).val( ui.item.state );
												  $( '#country' ).val( ui.item.country );
												  $( '#lat' ).val( ui.item.lat );
												  $( '#lng' ).val( ui.item.lng );
												  if(ui.item.zipcode.length==4){
												      ui.item.zipcode = '0' + ui.item.zipcode;
												  
												  }
												  if(ui.item.zipcode.length==3){
												      ui.item.zipcode = '00' + ui.item.zipcode;
												  
												  }	
												  $( this).val( ui.item.zipcode );
												  return false;
											    }
											    })
											    .autocomplete( "instance" )._renderItem = function( ul, item ) {
											    return $( "<li>" )
											    .append( "<a>" + item.description + "</a>" )
											    .appendTo( ul );
											    };
								});		
$('#city').click(function(){
								      $('#city').autocomplete({
											    minLength: 1,
											    source: '/ajax/cities/?q=' + $(this).val(),
											    focus: function( event, ui ) {
                                                
												return false;
											    },
											    select: function( event, ui ) {
												  
												  $( '#state' ).val( ui.item.state );
												  $( '#country' ).val( ui.item.country );
												  $( '#lat' ).val( ui.item.lat );
												  $( '#lng' ).val( ui.item.lng );
												  if(ui.item.zipcode.length==4){
												      ui.item.zipcode = '0' + ui.item.zipcode;
												  
												  }
												  if(ui.item.zipcode.length==3){
												      ui.item.zipcode = '00' + ui.item.zipcode;
												  
												  }	
												  $( '#postal_code' ).val( ui.item.zipcode );
												  $( this).val( ui.item.city );
												  return false;
											    }
											    })
											    .autocomplete( "instance" )._renderItem = function( ul, item ) {
											    return $( "<li>" )
											    .append( "<a>" + item.description + "</a>" )
											    .appendTo( ul );
											    };
								});	
</script>		
<script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
    <script>        
        function createUploader(elem, type){            
            var ajaxuploader = new qq.FineUploader({
                element: document.getElementById(elem),
                template: 'qq-template-gallery',
                multiple: false,
              //  ios: true,
             //   allowXdr: true,
             //   sendCredentials: true,
                
                request: {
                    forceMultipart: true,
                    params: { user_id: <?php echo $array['user_id']; ?>, which: type, table: 'users' },
                    endpoint: "<?php echo site_url();?>Uploader/upload"
                },
                thumbnails: {
                    placeholders: {
                        waitingPath: '<?php echo site_url();?>/public/js/placeholders/waiting-generic.png',
                        notAvailablePath: '<?php echo site_url();?>/public/js/placeholders/not_available-generic.png'
                    }
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
                },
                onComplete: function(response){
                  $('#preview-' + type).html('<img src="/public/uploads/' + response.uuid + '/' + respnse.filename + '" / >');
                  $('#' + type + '-uploader').hide();
                }, 
                onError: function(response){
                
                
                }

            });           
        }
       
        

        $(document).ready(function() {
        	
        	createUploader('avatar-uploader', 'avatar');
        	createUploader('logo-uploader', 'logo');
        });
        
        // Wrap in doc Ready 
        // don't wait for the window to load  
        //window.onload = createUploader;     
    </script>  
