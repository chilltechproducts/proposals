<h2>Select A Fan</h2>
<ul>
  <?php 
  
  foreach($blades as $m => $motor){ 
  //print_r($motor);
  ?>
     <li class="motor inline" onclick="submit_combo(<?php echo $this->uri->segment(5); ?>, <?php echo $this->uri->segment(4); ?>, <?php echo $this->uri->segment(3); ?>, <?php echo $motor['id']; ?>, <?php echo $proposal['client_id']; ?>, <?php echo $proposal['dealer_id']; ?>)" alt="<?php echo $motor['id']; ?>">
       <img src="/public/images/QBlade-3awards-970x1024.png" /><br />
       <b><?php echo $motor['part_name']; ?></b><br />
       
     
       
      
       
       
       
     
     </li>

  <?php } ?>
</ul> 
