<?php 
if(count($client['proposals']) > 0){
  include(dirname(__FILE__) . "/proposals_list.php");


}else{
print_r($client);
?>
<div class="col-lg-4 col-lg-offset-4">
<?php $array = $client; ?>
  
    <h2>Job Location</h2>
    <span class="alert-success"></span>
   
       
    <form id="registration_form" name="registration_form" action="javascript: add_proposal(<?php echo $client['user_id']; ?>, '<?php echo $proposal['proposal_id']; ?>');" >
            <div class="form-group">
                <label>Proposal Name<span>req.</span></label>
                <?php echo form_input(array('name'=>'proposal_name', 'id'=> 'proposal_name', 'placeholder'=>'Proposal Name', 'class'=>'form-control', 'value'=> set_value('proposal_name', $array['proposal_name']))); ?>
                <?php echo form_error('proposal_name');?>
            </div>
            <div class="form-group">
                <label>Address<span>req.</span></label>
                <?php echo form_input(array('name'=>'street_address', 'id'=> 'street_address', 'placeholder'=>'Street Address', 'class'=>'form-control', 'value'=> set_value('street_address', $proposal['street_address']?$proposal['street_address']:$array['street_address']))); ?>
                <?php echo form_error('street_address');?>
            </div>
             <div class="form-group">
                <label>Apt/Unit<span>opt.</span></label>
                <?php echo form_input(array('name'=>'street_address2', 'id'=> 'street_address2', 'placeholder'=>'Apt / Unit', 'class'=>'form-control', 'value'=> set_value('street_address2', $proposal['street_address']?$proposal['street_address']:$array['street_address2']))); ?>
                <?php echo form_error('street_address2');?>
            </div>
             <div class="form-group">
                <label>City<span>req.</span></label>
                <?php echo form_input(array('name'=>'city', 'id'=> 'city', 'placeholder'=>'City', 'class'=>'form-control', 'autocomplete' => 'off', 'value'=> set_value('city', $proposal['street_address']?$proposal['city']:$array['city']))); ?>
                <?php echo form_error('city');?>
            </div>
             <div class="form-group">
                <label>State<span>req.</span></label>
          
                <select id="state" name="state" class="form-control">
                <?php foreach($states as $state){
                ?>
                <option value="<?php echo $state; ?>" <?php if($state == $proposal['state']){ echo 'selected'; } ?>><?php echo $state; ?></option>
                <?php } ?>
                
                </select>
                <?php echo form_error('state');?>
            </div>
             <div class="form-group">
                <label>Zip Code<span>req.</span></label>
                <?php echo form_input(array('name'=>'postal_code', 'id'=> 'postal_code', 'placeholder'=>'Zip Code', 'class'=>'form-control', 'autocomplete' => 'off', 'value'=> set_value('postal_code', $proposal['street_address']?$proposal['postal_code']:$array['postal_code']))); ?>
                <?php echo form_error('postal_code');?>
            </div>
            <div class="form-group">
                <label>Utility Company<span>req.</span></label>
                <?php echo form_input(array('name'=>'utility_company', 'id'=> 'utility_company', 'placeholder'=>'Utility Company', 'class'=>'form-control', 'autocomplete' => 'off', 'value'=> set_value('utility_company', $proposal['utility_company']))); ?>
                <?php echo form_error('utility_company');?>
            </div>
            <div class="form-group">
                <label>Existing kwH<span>req.</span></label>
                <input step=".01" min="0" name="utility_kwH_rate" id="utility_kwH_rate" type="number" placeholder="Existing kwH" class="form-control number"  autocomplete="off" value="<?php echo $proposal['utility_kwH_rate']; ?>" />
                <?php echo form_error('utility_kwH_rate');?>
            </div>
            <?php echo form_input(array('type' => 'hidden', 'name' => 'client_id', 'id' => 'client_id', 'value' => $client['user_id'])); ?>
           <?php echo form_input(array('type' => 'hidden', 'name' => 'level_id', 'id' => 'level_id', 'value' => 5)); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'dealer_id', 'id' => 'dealer_id', 'value' => $this->session->userdata['user_id'])); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'user_id', 'id' => 'user_id', 'value' => $array['user_id'])); ?>
            <?php echo form_input(array('type' => 'hidden', 'name' => 'proposal_id', 'id' => 'proposal_id', 'value' => $proposal['proposal_id'])); ?>
    <?php if(!empty($array['user_id'])){ if($array['user_id'] == $this->session->userdata['user_id']){ $submit_label = 'Save Job Location'; }else{ $submit_label = 'Save Job Location'; } }else{ $submit_label='Save Job Location'; } ?>
    <?php echo form_submit(array('value'=>$submit_label, 'class'=>'btn btn-lg btn-primary btn-block', 'id' => 'id_submit_form')); ?>
    <?php echo form_close(); ?>
   
</div>
 
<script>
//https://openei.org/w/api.php?action=sfautocomplete&format=json&category=EIA%20Utility%20Companies%20and%20Aliases&po=%3FLogo&callback=jQuery19105694997847256146_1543333646768&substr=Eversource+of+Massachusett&_=1543333646769
function getkwH(utility){
url = 'https://openei.org/apps/USURDB/?utilRateFinder=' + encodeURIComponent(utility);
$.ajax({
       url: '/ajax/getkwH',
       data: { url: url},
       type:'post',
       success: function(reponse){
       
            
       }
   })    


}
$('#utility_company').click(function(){
								      $('#utility_company').autocomplete({
											    minLength: 1,
											    source: function(request, response) {
                                                        src = 'https://openei.org/w/api.php';
                                                        data = { substr:$('#utility_company').val(), format: 'json', action: 'sfautocomplete', category: 'EIA Utility Companies and Aliases' };
                                                        
                                                        $.ajax({
                                                                url: src,
                                                                dataType: 'jsonp',
											   
                                                                crossDomain: true,
                                                                data: data,
                                                                success: function(data) {
                                                                response(data.sfautocomplete);
                                                                }
                                                          });      
                                                },  
                                               
											    
											    select: function( event, ui ) {
											      $( this).val( ui.item.title );
											      
											      getkwH(ui.item.title);
											      return false;
											      }
											    })
											    .autocomplete( "instance" )._renderItem = function( ul, item ) {
											    
                                                    return $( "<li>" )
                                                        .append( "<a>" + item.title + "</a>" )
                                                        .appendTo( ul );
                                                   
											    };
											    });
											    
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
 
<?php } ?>
