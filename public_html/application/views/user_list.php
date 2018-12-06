<style>
.inline.buttons {

    clear: both;
    display: block;

}
.name.email {

    width: auto;
    display: inline-block;
    word-wrap: break-word;

}
.parts .name.inline {

    width: auto;
    display: inline-block;
    word-wrap: break-word;
    font-weight: bold;
    border-right: unset;
    margin-right: 36px;
    padding-right: 10px;
    font-size: 13px;

}
.hundred.block.exiting_proposals {
    margin-top: 10px !important;
    color: #fff;
}
.left.inline {

    width: 50%;
    float: left;
    display: ;

}
.right.inline {

    float: right;
    width: 40%;

}
</style>

<ul class="parts hundred clients">
        <?php   $i=0;
            foreach($data as $c => $client){
                $i++;
                if($i%2==0){
                    $odd_even = 'even';
                }else{
                    $odd_even = 'odd';
                }    
                ?>
                <li class="block row <?php echo $odd_even; ?>">
                    <span class="name inline">
                            <?php echo $client['first_name']; ?> <?php echo $client['last_name']; ?></span><br /><span class="name email"><?php echo $client['email']; ?><br />
                            <?php echo $client['street_address'];?><br /> <?php echo $client['city'];?>, <?php echo $client['state_province_code'];?> <?php echo $client['postal_code'];?><br />
                            <?php echo $client['business_phone']; ?>
                    </span>
                    <span class="inline buttons">
                        <i class="fa fa-close"></i>
                        <i class="fa fa-pencil" onclick="add_client(<?php echo $client['user_id']; ?>)"></i>
                    </span>
                        <ul class="hundred block exiting_proposals">
                           <?php
                           foreach($client['proposals'] as $p => $proposal){
                           ?>
                             <li>
                               
                                    <i class="fa fa-cog" onclick="load_proposals(<?php echo $client['user_id']; ?>, <?php echo $this->session->userdata['user_id'];?>, <?php echo $proposal['proposal_id']; ?>);"></i>
                                    <i onclick="load_proposal_details(<?php echo $client['user_id']; ?>, <?php echo $this->session->userdata['user_id'];?>, <?php echo $proposal['proposal_id']; ?>);" class="fa fa-eye"></i>
                               <span class="left inline"> <a href="javascript;;" onclick="load_proposal_details(<?php echo $client['user_id']; ?>, <?php echo $this->session->userdata['user_id'];?>, <?php echo $proposal['proposal_id']; ?>);"><?php echo $proposal['proposal_name']; ?></a></span><span class="right inline"><?php echo $proposal['street_address'];?><br /> <?php echo $proposal['city']; ?>, <?php echo $proposal['state']; ?><?php echo $proposal['postal_code'];?></span>
                             </li>
                           
                           <?php } ?>
                        </ul>
                </li>
       <?php } ?>         

</ul>



