<ul>
  <?php 
  
  foreach($motors as $m => $motor){ 
  //print_r($motor);
  ?>
     <li class="motor inline">
       <img src="/public/images/EC_Motor.png" /><br />
       <b><?php echo $motor['part_name']; ?></b><br />
       Model: #<?php echo $motor['model_number']; ?><br />
       kwH: <?php echo $motor['kWh']; ?><br />
       
       <span class="block"><b>Qty.</b><input type="number" value="" step="1" min="0" alt="<?php $unique = time() + $m; echo $unique; ?>" id="quantity_<?php echo $unique; ?>" class="qty"  onchange="setTimeout(function(){ blade_choices(<?php echo $unique; ?>, <?php echo $motor['id']; ?>, <?php echo $proposal['proposal_id']; ?>);}, 1000);" onkeyup="setTimeout(function(){ blade_choices(<?php echo $unique; ?>, <?php echo $motor['id']; ?>, <?php echo $proposal['proposal_id']; ?>);}, 1000);"/>
       
       
       
     
     </li>

  <?php } ?>
</ul>
