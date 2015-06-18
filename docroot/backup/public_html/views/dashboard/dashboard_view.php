<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        /*====================== Exemple basique ======================*/
        $("#parent1").wslide({
            width: 450,
            height: 200,
            duration: 2000,
            effect: 'easeOutBounce'
        });
        /*====================== Exemple 2 ======================*/
        $("#parent2").wslide({
            width: '100%',
            height: 284,
            //pos: 1,
            //horiz: true,
            autoplay: true ,
            fade: true,
            //delay: 2000,
            duration: 2000, 
            //type: 'sequence',
            //duration: 1000,
            //effect: 'easeOutElastic'
					
        });			
        /*====================== Exemple 3 ======================*/
        $("#parent3").wslide({
            width: 250,
            height: 300,
            col: 4,
            autolink: 'menu3',
            duration: 4000,
            effect: 'easeOutExpo'
        });
    });
</script>
<style>
    .t-top1 {
    background: none repeat scroll 0 0 #F9F9F9;
    border-bottom: 1px solid #D0D0D0;
    border-right: 1px solid #D0D0D0;    
    border-left: 1px solid #D0D0D0;
    color: #00537C;
    font-family: 'RobotoBlack';
    font-size: 15px;
    font-weight: normal;
    line-height: 27px;
    padding: 0 10px;    
    text-align: left;   
}
.t-top1:last-child {
    border-right: medium;
}
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Account Overview
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r"> 
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="dash-form">
                        <table width="100%">
                            <tr><th COLSPAN="2" class="t-top1" style="height: 30px;"><H1><strong>Account Information</strong></H1></th></tr>                            
                            <tr><td class="t-top1" width="40%">User Name</td><td class="t-top1" width="60%"><?php echo $info['user_name']; ?></td></tr>
                            <tr><td class="t-top1">Email</td><td class="t-top1"><?php echo $info['user_email']; ?></td></tr>
                            <tr><td class="t-top1">First Name</td><td class="t-top1"><?php echo $info['user_fname']; ?></td></tr>
                            <tr><td class="t-top1">Last Name</td><td class="t-top1"><?php echo $info['user_lname']; ?></td></tr>
                            <tr><td class="t-top1">Address </td><td class="t-top1"><?php echo $info['user_address']; ?></td></tr>
                            <tr><td class="t-top1">Address Add On</td><td class="t-top1"><?php echo $info['user_address_addon']; ?></td></tr>
                            <tr><td class="t-top1">Phone</td><td class="t-top1"><?php echo $info['user_phone']; ?></td></tr>
                            <tr><td class="t-top1">City</td><td class="t-top1"><?php echo $info['user_city']; ?></td></tr>
                            <tr><td class="t-top1">Country</td><td class="t-top1"><?php echo $user_country; ?></td></tr>
                              <tr><td class="t-top1">State</td><td class="t-top1"><?php echo $user_state; ?></td></tr>
                                <tr><td class="t-top1">Zip Code</td><td class="t-top1"><?php echo $info['user_zipcode']; ?></td></tr>
                                <tr><td COLSPAN="2" align="center" class="dash-inner dashorange" style="width: auto;margin-top: 4%;"><?php echo anchor('dashboard/manage_account', 'Edit', 'title="Edit"');?></th></tr>
                        
                                </table>                        
                           
                    </div>
                </div>




            </section></div>






    </div>
</div>