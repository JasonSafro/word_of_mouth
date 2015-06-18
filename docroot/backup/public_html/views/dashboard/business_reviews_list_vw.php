
<?php
//CSS
echo css_asset("address-popup.css");
echo css_asset("selectbox.css");
?>
<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.selectbox-0.5.js"); ?>



<link href="<?php echo base_url();?>assets/datepicker/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        
        $("#jobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
        
        $("#EjobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
        
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
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Business Review
                </div>
            </section></div>


        <div class="dash"><section id="main">
<?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <div class="post-right"></div>
                    <h1>Business Reviews</h1>
                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="15%" class="t-top3"align="center">Business</td>
                                <td width="15%" align="center" class="t-top3">Reviewer</td>
                                <td width="14%" align="center" class="t-top3">Professionalism</td>
                                <td width="14%" align="center" class="t-top3">Dependability</td> 
                                <td width="14%" align="center" class="t-top3">Price</td> 
                                <td width="14%" align="center" class="t-top3">Overall</td>
                                <td width="10%" align="center" class="t-top3">Status</td>
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                            
                           <?php $ratingNames=array('5'=>'Excellent','4'=>'Good','3'=>'Average','2'=>'Poor','1'=>'Awful');
                           if(!empty($reviewList)){
                           foreach($reviewList as $key=>$val){?> 
                            <tr>
                                <td class="t-top1" align="center"><?php echo $val['buss_name'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['rvwReviewerName'];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingProfessionalism']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingDependability']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingPrice']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingOverall']];?></td>
                                <td class="t-top1" align="center"><?php echo $val['rvwStatus'];?></td>
                                <td class="t-top1" align="center">
                                   <a class="" href="<?php echo site_url('dashboard/reviews/view_details/'.$val['rvwId']);?>" title="View details"><img src="<?php echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign"/></a>
                                </td>
                                </tr>
                            <?php }
                           }else{
                               echo '<tr><td class="t-top1" colspan="8">No business reviews found.</td></tr>';
                           }?>
                           
                        </table>
                    </div>                   
                    
                    <div style="clear:both; width: 100%; margin-bottom: 15px;"></div>
                    <h1>My Reviews</h1>
                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="30%" class="t-top3"align="center">Business</td>                                
                                <td width="14%" align="center" class="t-top3">Professionalism</td>
                                <td width="14%" align="center" class="t-top3">Dependability</td> 
                                <td width="14%" align="center" class="t-top3">Price</td> 
                                <td width="14%" align="center" class="t-top3">Overall</td>
                                <td width="10%" align="center" class="t-top3">Status</td>
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                           
                           <?php $ratingNames=array('5'=>'Excellent','4'=>'Good','3'=>'Average','2'=>'Poor','1'=>'Awful');
                           if(!empty($myReviewList)){
                           foreach($myReviewList as $key=>$val){?> 
                             <tr>
                                <td class="t-top1" align="center"><?php echo $val['buss_name'];?></td>                                
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingProfessionalism']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingDependability']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingPrice']];?></td>
                                <td class="t-top1" align="center"><?php echo $ratingNames[$val['rvwRatingOverall']];?></td>
                                <td class="t-top1" align="center"><?php echo $val['rvwStatus'];?></td>
                                <td class="t-top1" align="center">
                                   <a class="" href="<?php echo site_url('dashboard/reviews/view_details/'.$val['rvwId']);?>" title="View details"><img src="<?php echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign"/></a>
                                </td>
                                </tr>
                            <?php }
                           }else{
                               echo '<tr><td class="t-top1" colspan="8">No reviews found.</td></tr>';
                           }?>
                           
                        </table>
                    </div> 
                    
                    
                </div>




            </section></div>






    </div>
</div>