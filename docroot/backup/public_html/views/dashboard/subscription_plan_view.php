<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.selectbox-0.2.js"); ?>
<script type="text/javascript">
    $(function () {
        $("#country_id").selectbox();
    });
</script>
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
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Business list
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="15%" class="t-top"align="center">Plan Name</td>
                                <td width="20%" align="center" class="t-top">Sub-Plan Name</td>
                                <td width="15%" align="center" class="t-top">Start Date</td>
                                <td width="15%" align="center" class="t-top">End Date</td>
                                <td width="15%" align="center" class="t-top">Action</td>
                            </tr>


                            <tr>
                                <td class="t-top1"align="center"><?php echo $sub_plan;?></td>
                                <td align="center" class="t-top1"><?php echo $sub_sub_plan;?></td>
                                <td align="center" class="t-top1"><?php echo $start_date;?></td>
                                <td align="center" class="t-top1"><?php echo $end_date;?></td>
                                 <td align="center" class="t-top1"><?php echo anchor('dashboard/upgrade_subscription','Upgrade');?></td>
                            </tr>                       


                        </table>



                    </div>                   



                </div>




            </section></div>






    </div>
</div>