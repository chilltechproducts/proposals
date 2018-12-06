<style>
.slide {
    background-repeat: no-repeat;
    display: none;
 
    height: auto;
    background-size: 100% 100%;
  
}
.slick-slide {
    display: none;
    float: left;
    height: 100%;
    min-height: 600px;
}
#dealer_info img.logo {
    float: right;
    width: 275px;
    position: relative;
    top: -125px;
    left: -30px;
}
#dealer_info div {
    text-align: left;
    width: 50%;
    margin: 20px auto;
    font-size: 18px;
}
#dealer_info img.avatar {
    float: left;
    width: 100px;
    position: relative;
    top: -120px;
    left: 101px;
    border-radius: 50%;
    height: 100px;
}
.fa.fa-window-maximize.right {

    float: right;
    clear: right;
    display: table;
    margin-right: 10px;
    margin-top: 10px;
    margin-bottom: -10px;
    color: #fff;
    background-color: #666;
    padding: 5px;
    border-radius: 5px;
    cursor: pointer;
    position: relative;
    z-index: 1000;

}
#content_box {
background-color:#fff;
}
</style>
<?php if(!empty($this->input->get('ajax_set'))){ ?>
<i class="fa fa-window-maximize right" aria-hidden="true" onclick="window.open('/main/presentation', '_blank', 'location=no,height=570,width=1300,scrollbars=no,status=no');"></i>
<?php } ?>

<div id="carousel">
<?php
   for($i=1;$i<=6;$i++){
     if($i == 2 & !empty($me['presentation_slide'])){
       echo $me['presentation_slide'];
       }else{
     ?>
        <div class="slide" style="background-image: url('/public/presentation/slide<?php echo $i; ?>.png?<?php echo time(); ?>');">
           <?php if(!empty($data[$i]['text'])){ echo @$data[$i]['text']; } ?>
   
        </div>
   <?php
   }
   }
?>   
</div>
<script>
$('#carousel').slick();
$('#carousel').on('afterChange', function(event, slick, currentSlide) {
  console.log(slick, currentSlide);
  if (slick.$slides.length-1 == currentSlide) {
    $('.slick-next.slick-arrow').html('Build Proposal').attr('onclick', "ajax_page('/main/create_proposal/?ajax_set=1');");
  }
})
</script>
