<div class="container">
<h3>Chill Tech Order Proposal System</h3>
<p class="avatar_box"><?php if(!empty($this->session->userdata['avatar'])){ ?><img src="<?php echo $this->session->userdata['avatar']; ?>" /><?php } if(!empty($this->session->userdata['user_id'])){ ?>Welcome, <?php echo $me['first_name']?$me['first_name']  . '  ' .  $me['last_name']:$me['email']; }else{ ?><a class="button login" href="javascript:;" onclick="login_form();">Login</a><?php } ?></p>

<img src="/public/images/ch1ll-tech-logo-blank-background_2.png" class="inline right" />

<ul id="navigation" class="nav">
  
   <li class="inline">
      <a href="https://chilltechproducts.com/">Home</a>
      <button class="btn btn-secondary dropdown-toggle" type="button"  id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropright</span></button>
        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton4">
      <a href="https://chilltechproducts.com/" class="dropdown-item">About</a>
      <a href="https://chilltechproducts.com/welcome/contact" class="dropdown-item">Contact</a>
      </div>
   </li>   
   <li class="inline">
      <a href="javascript:;" onclick="ajax_page('/main/presentation/?ajax_set=1');">Presentation</a>
      <button class="btn btn-secondary dropdown-toggle" type="button"  id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropright</span></button>
        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton3">
                <a href="javascript:;" onclick="ajax_page('/main/find_proposal/?ajax_set=1');" class="dropdown-item">Find Proposal</a>
                <a href="javascript:;" onclick="ajax_page('/main/create_proposal/?ajax_set=1');" class="dropdown-item">Create Proposal</a>
        </div>        
   </li>
   <li class="inline">
      <a href="">LCA Portal</a>
   </li>
   <!--<li class="inline">
      <a href="">Warrenties</a>
   </li>-->
 <?php if(!empty($this->session->userdata['user_id'])){ ?>
   <li class="inline">
      <a href="">Products <!--Ordering--></a>
      <button class="btn btn-secondary dropdown-toggle" type="button"  id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropright</span></button>
        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton2">
            <!--<a class="dropdown-item" href="">Order Part</a>
            <a class="dropdown-item" href="">Information</a>-->
            <a class="dropdown-item" href="javascript:;" onclick="find_parts();">Find / Order Parts</a>
            <a class="dropdown-item" href="">Lookup QRCode</a>
            <a class="dropdown-item" href="javascript:;" onclick="my_parts();">My Parts</a>
            <?php if($me['level_info']['level_id']  <= 5){ ?>
                <a class="dropdown-item" href="javascript:;" onclick="add_part();">Add Part</a>
                <a class="dropdown-item" href="javascript:;" onclick="import_parts();">Import Part(s)</a>
            <?php } ?>
        </div>
        
   </li>
   <?php } ?>
   <!--<li class="inline">
      <a href="">Product Information</a>
   </li>   -->
   <li class="inline">
      <a href="">Rebates</a>
   </li>  
   <?php if(!empty($this->session->userdata['user_id'])){ ?>
   <li class="inline dropdown">
      <a href="">My Profile</a>
      <button class="btn btn-secondary dropdown-toggle" type="button"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropright</span></button>
        <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
          <?php if($me['level_info']['level_id'] == 1){ ?>
                    <p>Admininstrator</p>
                    <a href="" class="dropdown-item">Dealers Reports / List</a>
                    <a href="" class="dropdown-item">Subscriptions</a>
              
          <?php } ?>
          <?php if($me['level_info']['level_id'] == 2 | $me['level_info']['level_id'] == 1){ ?>
                    <p>Dealer</p>
                    <a href="javascript:;" onclick="sales_staff();" class="dropdown-item">Sales Staff List</a>
                    <a href="" class="dropdown-item">Account / Billing</a>
                    <a href="" class="dropdown-item">Current Proposals</a>
                    <a href="" class="dropdown-item">Analytics / Reports</a>
                    <a href="" class="dropdown-item">Export / Print Data</a>
              
          <?php }
             if($me['level_info']['level_id'] != 8) {?>
                    <p>Salesmen / Office</p>
                     <a href="javascript:;" onclick="load_profile('<?php echo $this->session->userdata['user_id']; ?>');" class="dropdown-item">My Profile</a>
                     <a href="javascript:;" onclick="get_clients();" class="dropdown-item">Clients</a>
                     <a href="/main/logout" class="dropdown-item">Logout</a>
             <?php }else{ 
             if(!empty($this->session->userdata['user_id'])){ ?>  
                    
                     <a href="javascript;" onclick="load_profile('<?php echo @$this->session->userdata['user_id']; ?>');" class="dropdown-item">My Profile</a>
                     <a href="" class="dropdown-item">Dealers</a>
                     <a href="/main/logout" class="dropdown-item">Logout</a>
             <?php } 
             }
             ?>        
        </div>
   </li>   
   <?php } ?>
</ul>
<?php if($_SERVER['SERVER_NAME'] == 'chilltechproducts.com'){ ?>
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
<div class="right content_box" id="content_box"></div>
<script>
<?php if(empty($this->session->userdata['user_id'])){ ?>
$(document).ready(function(){
   $.ajax({
          url: '/main/login/?ajax_set=1',
          success: function(response){
           $('#content_box').html(response); 
          
                    
          }
    });      
});
<?php }else{ ?>
ajax_page('/main/presentation/?ajax_set=1');
<?php } ?>
</script>
<br />
<?php 

if(!empty($_REQUEST['redirect'])){
   $link = base64_decode($_REQUEST['redirect']);
   ?>
   <script>
     setTimeout(function(){
         $.ajax({
           url: '<?php echo $link; ?>',
           success: function(response){
                $('#content_box').html(response);
           }
       });
       }, 2000);
    </script>
<?php } ?> 
</div>
<!--199.34.228.77--><!--50.63.167.68-->
  
