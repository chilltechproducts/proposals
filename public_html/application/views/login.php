<div class="col-lg-4 col-lg-offset-4">
<script src='https://www.google.com/recaptcha/api.js'></script>
    <h2>Please login</h2>
    <?php $fattr = array('class' => 'form-signin', 'id' => 'email_form');
         echo form_open(site_url().'main/login', $fattr); ?>
    <div class="form-group">
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'value'=> set_value('email'))); ?>
      <?php echo form_error('email') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array(
          'name'=>'password', 
          'id'=> 'password', 
          'placeholder'=>'Password', 
          'class'=>'form-control', 
          'value'=> set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>

    <div class="g-recaptcha" data-sitekey="6LeVonoUAAAAAFB13KjOGRJHOOaQdWoi75CpS99m"></div>
   
    <?php echo form_submit(array('value'=>'Let me in!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
    <?php echo form_close(); ?>
    <p>Don't have an account? Click to <a href="<?php if(empty($_REQUEST['ajax_set'])){ echo site_url();?>/welcome/schedule?ajax_set=<?php echo $_REQUEST['ajax_set']; }else{ ?>javascript: ajax_register(); <?php } ?>">Register</a></p>
    <p>Click <a href="<?php if(empty($_REQUEST['ajax_set'])){  echo site_url();?>main/forgot?ajax_set=<?php echo $_REQUEST['ajax_set']; }else{ ?>javascript: ajax_recover(); <?php } ?>">here</a> if you forgot your password.</p>
</div>
