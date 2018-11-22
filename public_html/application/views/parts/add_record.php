<?php 
if(!empty($this->input->get('i'))){
  $i = $this->input->get('i');
}

?>
<div class="form-group">
   <input type="text" name="key[<?php echo $i-1; ?>]" id="key_<?php echo $i-1; ?>" value="" class="left inline"  />
   
   
   <input type="number" name="value[<?php echo $i-1; ?>]" id="value_<?php echo $i-1; ?>" value="" class="right inline" />
  
   <select name="unit[<?php echo $i-1; ?>]" id="unit_<?php echo $i-1; ?>">
   <?php 
   
   
  
    
     
   foreach($units as $u => $unit){
   ?>
     <option value="<?php echo strtolower($unit['CommonCode']); ?>" ><?php echo ucwords($unit['Name']); ?> </option>
   <?php } ?>
   </select>
<i class="right block clear fa fa-close" onclick="$(this).parent().remove();"></i> 
</div>
