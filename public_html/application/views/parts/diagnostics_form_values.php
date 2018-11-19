<ul class="hundred block diag_header"><li class="left inline">Name of Setting</li><li class="right inline">Value</li><li class="right inline">Unit</li></ul>

<?php 
$unwantedChars = array(',' ,
                        '!',
                         '?',
                         '%',
                         '$',
                         '*',
                         '|',
                         '{',
                         '}',
                         '[',
                         ']',
                         '(',
                         ')',
                         '^',
                         '#',
                         '@',
                         '&');
foreach($data as $k1 => $a1){

  $row = json_decode($a1->json, true);
  $i=0;
 foreach($row as $k => $v){
 
 
?>

<div class="form-group">
   <input type="text" name="key[<?php echo $i; ?>]" id="key_<?php echo $i; ?>" value="<?php echo $k; ?>" class="left inline"  />
   
   
   <input type="number" name="value[<?php echo $i; ?>]" id="value_<?php echo $i; ?>" value="<?php echo str_replace($unwantedChars, "", preg_replace("/[a-z]+/i", "", $row[$k])); ?>" class="right inline" />
   <?php 
    $unwantedChars[] = '.';
 
  // echo str_replace($unwantedChars, "", preg_replace("/[0-9]+/i", "", $row[$k]));
   ?>
   <select name="unit[<?php echo $i; ?>]" id="unit_<?php echo $i; ?>">
   <?php 
   
   
  
    
     
   foreach($units as $u => $unit){
   ?>
     <option value="<?php echo strtolower($unit['CommonCode']); ?>" <?php if(str_replace($unwantedChars, "", preg_replace("/[0-9]+/i", "", $row[$k])) == strtolower($unit['CommonCode'])){ ?> selected<?php } ?>><?php echo ucwords($unit['Name']); ?> </option>
   <?php } ?>
   </select>
<i class="right block clear fa fa-close" onclick="$(this).parent().remove();"></i>
</div>


<?php 
$i++;

}
}
$row[$k] = '';
$k = '';
$i++;
include(dirname(__FILE__) . "/add_record.php");
?>




<i class="right block clear fa fa-save" onclick="save_diagnotics(<?php echo $this->uri->segment(3); ?>, <?php echo $this->uri->segment(4); ?>);"></i>
<i class="right block clear fa fa-plus" onclick="add_diagnostic_row(<?php echo $this->uri->segment(3); ?>, <?php echo $this->uri->segment(4); ?>);"></i>
