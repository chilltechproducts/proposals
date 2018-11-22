<div class="container">
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
    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
