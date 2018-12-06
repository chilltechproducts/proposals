<ul>

<?php 
$parts_totals = 0;
$rebates = 0;



foreach($parts as $p => $motor){

if($part['limit_amount_per_customer'] < $part['count']){
  $limit = $part['limit_amount_per_customer'];
}else{

 $limit =  $part['count'];
}
$rebates = $rebates + ($part['rebate_amount'] * $limit);
$p++;
?>
    <li class="motor inline">
       <img src="/public/images/EC_Motor.png" /><br />
       <i class="fa fa-close" onclick="delete_part(<?php echo $motor['unique_val']; ?>, <?php echo $proposal['client_id']; ?>, <?php echo $proposal['dealer_id']; ?>, <?php echo $proposal['proposal_id']; ?>);"></i>
       <b><?php echo $motor['part_name']; ?></b><br /> with blade: <?php echo $motor['blade']['part_name']; ?><br />
       Model: #<?php echo $motor['model_number']; ?><br />
       kwH: <?php echo $motor['kWh_with_blade']; ?><br />
       
       <span class="block"><b>Qty.</b><input type="number" value="<?php echo $motor['count']; ?>" step="1" min="0" alt="<?php echo $motor['unique_val']; ?>" id="quantity_<?php echo $motor['unique_val']; ?>" class="qty"  onchange="setTimeout(function(){ submit_combo(<?php echo $motor['unique_val']; ?>, <?php echo $motor['part_id']; ?>,  <?php echo $proposal['proposal_id']; ?>,  <?php echo $motor['blade']['id']; ?>, <?php echo $proposal['dealer_id']; ?>);}, 1000);"/>
       
       
       <!--submit_part_to_server(part_id, proposal_id, unique, blade_id)-->
     
     </li>
<?php
}
$p =0;
unset($part);
?>
</ul>


<div class="form-control parts_totals">
<span class="inline totals">
<?php $taxes = $parts_totals * ($proposal['sales_tax'] / 100); ?>
  <b>Part Total Cost: </b>$<?php echo $parts_totals; ?><br />
  <b>Rebates: </b>$<?php echo $rebates; ?><br />
  <b>Taxes: </b>$<?php echo number_format($taxes,2); $parts_totals = number_format($parts_totals + $taxes, 2); ?><br />
  <b>Subtotal of Parts:</b>$<?php echo $parts_totals - $rebates; ?>
  <div class="final_total" style="display:none;"><?php echo $parts_totals - $rebates; ?></div>
</span>
</div>                            
