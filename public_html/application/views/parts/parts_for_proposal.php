<?php 
$parts_totals = 0;
$rebates = 0;
foreach($parts as $p => $part){

if($part['limit_amount_per_customer'] < $part['count']){
  $limit = $part['limit_amount_per_customer'];
}else{

 $limit =  $part['count'];
}
$rebates = $rebates + ($part['rebate_amount'] * $limit);
$p++;
?>
    <div class="form-control" id="part_data_<?php echo $p; ?>" alt="<?php echo $p; ?>">
    <i class="fa fa-close"></i>
          <ul>
            <li class="inline name">
               <input type="text" name="part_name[<?php echo $p; ?>]" id="part_name_<?php echo $p; ?>" value="<?php echo $part['part_name'];?>" alt="<?php echo $p; ?>" />
            </li>
            <li class="inline model_number">
               <input type="text" name="model_number[<?php echo $p; ?>]" id="model_number_<?php echo $p; ?>" value="<?php echo $part['model_number'];?>" alt="<?php echo $p; ?>" disabled />
            </li>
            <li class="inline quantity">
               <input type="number" name="quantity[<?php echo $p; ?>]" value="<?php echo $part['count']; ?>" class="qty" id="quantity_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
              
            </li>
            <li class="inline totals">
               <b>Cost Ea.:</b>$<?php echo $part['wholesale']; ?><br />
              <!-- <b>Wholesale:</b><?php echo $part['wholesale']; ?><br />-->
               <b>Total Cost:</b>$<?php echo $part['count'] * $part['wholesale']; ?>
               <?php $parts_totals = $parts_totals + ($part['count'] * $part['wholesale']); ?>
            </li>
          </ul>
          
           <input type="hidden" name="part_id[<?php echo $p; ?>]" value="<?php echo $part['part_id']; ?>" id="part_id_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
    </div>
<?php
}
$p =0;
unset($part);
?>

<div class="form-control" id="part_data_<?php echo $p; ?>" alt="<?php echo $p; ?>">
          <ul>
            <li class="inline name">
               <input type="text" name="part_name[<?php echo $p; ?>]" id="part_name_<?php echo $p; ?>" value="<?php echo $part['part_name'];?>" alt="<?php echo $p; ?>" />
            </li>
            <li class="inline model_number">
               <input type="text" name="model_number[<?php echo $p; ?>]" id="model_number_<?php echo $p; ?>" value="<?php echo $part['model_number'];?>" disabled alt="<?php echo $p; ?>" />
            </li>
            <li class="inline quantity">
               <input type="number" name="quantity[<?php echo $p; ?>]" value="<?php echo $part['count']; ?>" id="quantity_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
               
            </li>
            <li class="inline totals"></li>
          </ul>
          <input type="hidden" name="part_id[<?php echo $p; ?>]" value="<?php echo $part['count']; ?>" id="part_id_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
    </div>
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
