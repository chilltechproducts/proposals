<div class="col-lg-4 col-lg-offset-4">
<?php $array = $client; ?>
  
    <h2>Update / Add Client</h2>
    <span class="alert-success"></span>
   
       
    <form id="registration_form" name="registration_form" action="javascript: add_client();" >
    
    <div class="form-group">
                <label>Company Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'company_name', 'id'=> 'company_name', 'placeholder'=>'Company Name', 'class'=>'form-control', 'value' => set_value('company_name', $array['company_name']?$array['company_name']:$array['first_name'] . ' ' . $array['last_name'] )  )   ); ?>
                <?php echo form_error('first_name');?>
            </div>
    
     <div class="form-group">
      <label>Email</label>
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
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
          
            
           <?php echo form_input(array('type' => 'hidden', 'name' => 'level_id', 'id' => 'level_id', 'value' => 5)); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'dealer_id', 'id' => 'dealer_id', 'value' => $this->session->userdata['user_id'])); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'user_id', 'id' => 'user_id', 'value' => $array['user_id'])); ?>
        
    <?php if(!empty($array['user_id'])){ if($array['user_id'] == $this->session->userdata['user_id']){ $submit_label = 'Save My Account'; }else{ $submit_label = 'Save User Account'; } }else{ $submit_label='Save User Account'; } ?>
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

