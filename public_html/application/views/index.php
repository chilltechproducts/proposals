
<h3>Chill Tech Order Proposal System</h3>
<p>Welcome, <?php echo $data['user']['first_name']  . '  ' .  $data['user']['last_name']; ?></p>
<ul id="navigation" class="nav">
   <li class="inline">
      <a href="">Presentation</a>
   </li>
   <li class="inline">
      <a href="">LCA Portal</a>
   </li>
   <li class="inline">
      <a href="">Warrenties</a>
   </li>
   <li class="inline">
      <a href="">Product Ordering</a>
   </li>
   <li class="inline">
      <a href="">Product Information</a>
   </li>   
   <li class="inline">
      <a href="">Rebates</a>
   </li>  
   <li class="inline dropdown">
      <a href="">My Profile</a>
      <button class="btn btn-secondary dropdown-toggle" type="button"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropright</span></button>
        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
          <?php if($data['user']['level_id'] == 1){ ?>
                    <p>Admininstrator</p>
                    <a href="" class="dropdown-item">Dealers Reports / List</a>
                    <a href="" class="dropdown-item">Subscriptions</a>
              
          <?php } ?>
          <?php if($data['user']['level_id'] == 2 | $data['user']['level_id'] == 1){ ?>
                    <p>Dealer</p>
                    <a href="javascript: sales_staff();" class="dropdown-item">Sales Staff List</a>
                    <a href="" class="dropdown-item">Account / Billing</a>
                    <a href="" class="dropdown-item">Current Proposals</a>
                    <a href="" class="dropdown-item">Analytics / Reports</a>
                    <a href="" class="dropdown-item">Export / Print Data</a>
              
          <?php }
             if($data['user']['level_id'] != 8) {?>
                    <p>Salesmen / Office</p>
                     <a href="javascript: load_profile('<?php echo $this->session->userdata['user_id']; ?>');" class="dropdown-item">My Profile</a>
                     <a href="" class="dropdown-item">Clients</a>
                     <a href="/main/logout" class="dropdown-item">Logout</a>
             <?php }else{ ?>  
                    
                     <a href="javascript: load_profile('<?php echo $this->session->userdata['user_id']; ?>');" class="dropdown-item">My Profile</a>
                     <a href="" class="dropdown-item">Dealers</a>
                     <a href="/main/logout" class="dropdown-item">Logout</a>
             <?php } ?>        
        </div>
   </li>   
</ul>
<?php if($_SERVER['SERVER_NAME'] == 'chilltech.ddns.net'){ ?>
<ul class="left boxes block">
   <li class="block">
     <a href="">Build Proposal</a>
   </li>
   <li class="block">
     <a href="">Proposal Lookup</a>
   </li>
   <li class="block">
     <a href="">Training</a>
   </li>   
</ul>
<?php } ?> 
<div class="right content_box" id="content_box">Content will load dynamocally over here</div>
<br />
<p>Changed this slightly to have drop down menus instead in order to make navigation simpler</p>
