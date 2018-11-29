<?php 
$parts_totals = 0;
foreach($parts as $p => $part){

$p++;
?>
    <div class="form-control" id="service_data_<?php echo $p; ?>" alt="<?php echo $p; ?>">
    <i class="fa fa-close"></i>
          <ul>
            <li class="inline name">
               <input type="text" name="service_name[<?php echo $p; ?>]" id="service_name_<?php echo $p; ?>" value="<?php echo $part['service_name'];?>" alt="<?php echo $p; ?>" />
            </li>
            <li class="inline model_number">
               <input type="number" name="service_rate[<?php echo $p; ?>]" id="service_rate_<?php echo $p; ?>" value="<?php echo $part['rate'];?>" alt="<?php echo $p; ?>" /><i>price per</i>
            </li>
            <li class="inline quantity">
               <input type="number" name="value[<?php echo $p; ?>]" value="<?php echo $part['value']; ?>" class="qty" id="value_<?php echo $p; ?>" alt="<?php echo $p; ?>" /><i>(hrs./am.)</i>
              
            </li>
            <li class="inline totals">
              
               <b>Total Cost:</b>$<?php echo $part['value'] * $part['rate']; ?>
               <?php $parts_totals = $parts_totals + ($part['rate'] * $part['value']); ?>
            </li>
          </ul>
          
           <input type="hidden" name="service_id[<?php echo $p; ?>]" value="<?php echo $part['service_id']; ?>" id="service_id_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
    </div>
<?php
}
$p =0;
unset($part);
?>

<div class="form-control" id="service_data_<?php echo $p; ?>" alt="<?php echo $p; ?>">
          <ul>
            <li class="inline name">
               <input type="text" name="service_name[<?php echo $p; ?>]" id="service_name_<?php echo $p; ?>" value="<?php echo $part['service_name'];?>" alt="<?php echo $p; ?>" />
            </li>
            <li class="inline model_number">
               <input type="number" name="service_rate[<?php echo $p; ?>]" id="service_rate_<?php echo $p; ?>" value="<?php echo $part['rate'];?>" alt="<?php echo $p; ?>" /><i>price per</i>
            </li>
            <li class="inline quantity">
               <input type="number" name="value[<?php echo $p; ?>]" value="<?php echo $part['value']; ?>" class="qty" id="value_<?php echo $p; ?>" alt="<?php echo $p; ?>" /><i>(hrs./am.)</i>
              
            </li>
            <li class="inline totals"></li>
          </ul>
          <input type="hidden" name="service_id[<?php echo $p; ?>]" value="<?php echo $part['count']; ?>" id="service_id_<?php echo $p; ?>" alt="<?php echo $p; ?>" />
    </div>
<div class="form-control parts_totals">
<span class="inline totals">

  <b>Labor Total Cost:</b>$<?php echo $parts_totals; ?>
  <div class="final_total"  style="display:none;"><?php echo $parts_totals; ?></div>
</span>
</div>                            
