<?php 
if(count($client['proposals']) > 0){
  include(dirname(__FILE__) . "/proposals_list.php");


}else{
?>
<div class="col-lg-4 col-lg-offset-4">
<?php $array = $client[0]; $proposal = $proposal[0]; ?>
  
    
    <div class="row block hundred  dealer_details">
                <img src="<?php echo $me['logo']; ?>" class="right" />
                <p class="left">
                  <b><?php echo $me['company_name']; ?></b><br />
                   <?php echo $me['street_address']; ?> <?php echo $me['street_address2']; ?><br />
                   <?php echo $me['city']; ?>, <?php echo $me['state']; ?> <?php echo $me['postal_code']; ?><br />
                   <?php echo $me['business_phone']; ?><br />
                   <?php echo $me['user_website']; ?>
                </p>
                <span class="proposal_date">Proposal Date: <?php echo date('Y/m/d', strtotime($proposal['proposal_date'])); ?></span>
    </div>
     <div class="row block hundred  client_details">
            <span>Client Details</span>
            <?php if(!empty($client['avatar'])){ ?>
                <img src="<?php echo $client['avatar']; ?>" class="right" />
            <?php } ?>    
                <p class="left">
                  <b><?php echo $client['company_name']?$client['company_name']:$client['first_name']. ' ' . $client['last_name']; ?></b><br />
                   <?php echo $client['street_address']; ?> <?php echo $me['street_address2']; ?><br />
                   <?php echo $client['city']; ?>, <?php echo $client['state']; ?> <?php echo $client['postal_code']; ?><br />
                   <?php echo $client['business_phone']; ?><br />
                   
                   
                   <?php echo $client['user_website']; ?><br />
                </p>
    </div>
     <div class="row block hundred location_details">
                <span>Job Location</span>
                <p class="left">
                  <b><?php echo $proposal['proposal_name']; ?></b><br />
                   <?php echo $proposal['street_address']; ?> <?php echo $proposal['street_address2']; ?><br />
                   <?php echo $proposal['city']; ?>, <?php echo $proposal['state']; ?> <?php echo $proposal['postal_code']; ?><br />
                   <?php echo $proposal['utility_company'] ?> <?php echo $proposal['utility_kwH_rate']?$proposal['utility_kwH_rate'].'kwH':''; ?><br />
                   <?php echo $proposal['distance'] . ' miles from dealer location'; ?>
                </p>
    </div>
    </div>
    <div class="col-lg-4 col-lg-offset-4">
    <br />
     <h2>Job Proposal</h2>
    <span class="alert-success"></span>  
    <form id="registration_form" name="registration_form" action="javascript: add_proposal_data(<?php echo $client['user_id']; ?>, <?php echo $proposal['proposal_id']; ?>);" >
            <div class="form-group item_breakdown">
            
            
            </div>
            <div class="form-group item_breakdown" id="warranty_info">
               <p><b>AUTHORIZED Warranty:</b></p>
                    <b>Installation:</b><br />
                    Date Equipment of installation. warranty All provided motors by and Manufacturer. equipment will “Dealer” be registered will provide through materials Chill Tech and DEALER
                    Products, labor warranty Inc. to for validate (1) One warranty.
                    year from
                    Installation will be provided during normal business hours and access to all equipment will be provided by customer
                    to the extent reasonably acceptable by both parties.
                    <br />
                    <b>Estimates:</b><br />
                    The summary included in this proposal is based on estimates from nationwide data provided by manufacturer. Average Duty
                    cycles, kWh draws of existing equipment, and draws of new motors are used in determining potential savings. An on site energy
                    audit of existing equipment can be used for a more certain savings, however, this can only be performed by a qualified technician
                    and will be billed at normal service rates if opted for by customer.


               <div id="company_warranty" contenteditable="true"><?php echo $proposal['warranty']?$proposal['warranty']:$dealer['warranty']; ?></div>
                <div id="salesman_warranty" contenteditable="true"><?php echo $proposal['salesman_warranty']?$proposal['salesman_warranty']:$me['warranty']; ?></div>
            </div>
            
            
          
            <div class="form-group item_breakdown" id="parts_info">
              <h2>Parts Selected</h2>
              <div><?php require(dirname(dirname(__FILE__)) . "/parts/parts_for_proposal.php"); ?></div>
              
            </div>
             <div class="form-group item_breakdown" id="available_parts_info_new">
              <h2>Available Parts</h2>
              <div><?php require(dirname(dirname(__FILE__)) . "/parts/available_parts.php"); ?></div>
              
            </div>
           
            <?php echo form_input(array('type' => 'hidden', 'name' => 'client_id', 'id' => 'client_id', 'value' => $client['user_id'])); ?>
           <?php echo form_input(array('type' => 'hidden', 'name' => 'level_id', 'id' => 'level_id', 'value' => 5)); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'dealer_id', 'id' => 'dealer_id', 'value' => $this->session->userdata['user_id'])); ?> 
           <?php echo form_input(array('type' => 'hidden', 'name' => 'user_id', 'id' => 'user_id', 'value' => $array['user_id'])); ?>
            <?php echo form_input(array('type' => 'hidden', 'name' => 'proposal_id', 'id' => 'proposal_id', 'value' => $proposal['proposal_id'])); ?>
    <?php if(!empty($array['user_id'])){ if($array['user_id'] == $this->session->userdata['user_id']){ $submit_label = 'Save Job Proposal'; }else{ $submit_label = 'Save Job Proposal'; } }else{ $submit_label='Save Job Proposal'; } ?>
    <?php echo form_submit(array('value'=>$submit_label, 'class'=>'btn btn-lg btn-primary btn-block', 'id' => 'id_submit_form')); ?>
    <?php echo form_close(); ?>
   
</div>
 
<?php } ?>
<script>
$('form').bind("keypress", function(e) {
  if (e.keyCode == 13) {               
    e.preventDefault();
    return false;
  }
});
</script>
