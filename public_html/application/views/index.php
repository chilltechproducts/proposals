
<h3>Chill Tech Order Proposal System</h3>
<p class="avatar_box"><?php if(!empty($data['user']['avatar'])){ ?><img src="<?php echo $data['user']['avatar']; ?>" /><?php } if(!empty($this->session->userdata['user_id'])){ ?>Welcome, <?php echo $data['user']['first_name']  . '  ' .  $data['user']['last_name']; }else{ ?><a class="button login" href="javascript:;" onclick="login_form();">Login</a><?php } ?></p>
<img src="/public/images/ch1ll-tech-logo-blank-background_2.png" class="inline right" />

<ul id="navigation" class="nav">
   <li class="inline">
      <a href="">About</a>
   </li>
   <li class="inline">
      <a href="">Contact</a>
   </li>
   <li class="inline">
      <a href="">Presentation</a>
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
            <a class="dropdown-item" href="">Order Part</a>
            <a class="dropdown-item" href="">Information</a>
            <a class="dropdown-item" href="">Warranties</a>
            <a class="dropdown-item" href="">Lookup QRCode</a>
            <a class="dropdown-item" href="javascript:;" onclick="my_parts();">My Parts</a>
            <?php if($data['user']['level_id']  <= 5){ ?>
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
             <?php }else{ 
             if(!empty($this->session->userdata['user_id'])){ ?>  
                    
                     <a href="javascript: load_profile('<?php echo @$this->session->userdata['user_id']; ?>');" class="dropdown-item">My Profile</a>
                     <a href="" class="dropdown-item">Dealers</a>
                     <a href="/main/logout" class="dropdown-item">Logout</a>
             <?php } 
             }
             ?>        
        </div>
   </li>   
   <?php } ?>
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
<div class="right content_box" id="content_box"></div>
<script>
$(document).ready(function(){
   $.ajax({
          url: 'welcome',
          success: function(response){
           $('#content_box').html(response); 
           $('#carousel').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true
                });
                    
          }
    });      
});
</script>
<br />
<p>Changed this slightly to have drop down menus instead in order to make navigation simpler</p>
