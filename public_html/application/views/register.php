<div class="col-lg-4 col-lg-offset-4">
    <h2>Hello There</h2>
    <h5>Please enter the required information below.</h5>     
<?php 
    $fattr = array('class' => 'form-signin');
    echo form_open('/main/register', $fattr); ?>
    <div class="form-group">
      <?php echo form_input(array('name'=>'first_name', 'id'=> 'first_name', 'placeholder'=>'First Name', 'class'=>'form-control', 'value' => set_value('first_name'))); ?>
      <?php echo form_error('first_name');?>
    </div>
    <div class="form-group">
      <?php echo form_input(array('name'=>'last_name', 'id'=> 'last_name', 'placeholder'=>'Last Name', 'class'=>'form-control', 'value'=> set_value('last_name'))); ?>
      <?php echo form_error('last_name');?>
    </div>
    <div class="form-group">
      <?php echo form_input(array('name'=>'email', 'id'=> 'email', 'placeholder'=>'Email', 'class'=>'form-control', 'value'=> set_value('email'))); ?>
      <?php echo form_error('email');?>
    </div>
    <?php echo form_submit(array('value'=>'Sign up', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
    <?php echo form_close(); ?>
</div>
