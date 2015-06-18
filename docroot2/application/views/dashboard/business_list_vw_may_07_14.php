
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
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Business Listing
                </div>
            </section></div>


        <div class="dash"><section id="main">
        <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <?php echo $this->load->view('success_error_message_area');?>
                    <?php 
                    $myUserType=$this->session->userdata('user_type');
                    $myUserId=$this->session->userdata('user_id');
                    if($myUserType=='buss_user'){
                        $canIAddNewBusiness=true;
                        $numOfBusinessAdded=__numOfUserBusiness($myUserId);
                        $mySubscriptionPlan=__mySubscriptionPlan($myUserId);
                        if(($mySubscriptionPlan=='bm' || $mySubscriptionPlan=='ba') && $numOfBusinessAdded==2)//this means user have basic plan and have reached the creating business limit
                            $canIAddNewBusiness=false;
                        
                        if($canIAddNewBusiness==true){ ?>
                            <div class="post-right"><a class="button4" href="<?php echo site_url('dashboard/business_listing/add');?>">New Business</a></div>
                    <?php 
                        }
                    }?>
                    
                    <div class="post-right"></div>
                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="t-top3"align="center">Logo</td>
                                <td class="t-top3"align="center">Business Name</td>
                                <td align="center" class="t-top3">Category</td>
                                <td align="center" class="t-top3">Status</td>
                                <td align="center" class="t-top3">Date</td> 
                                <td align="center" class="t-top3">Action</td>
                                <!--<td width="14%" class="t-top3"align="center">Logo</td>
                                <td width="25%" class="t-top3"align="center">Business Name</td>
                                <td width="15%" align="center" class="t-top3">Category</td>
                                <td width="15%" align="center" class="t-top3">Status</td>
                                <td width="15%" align="center" class="t-top3">Date</td> 
                                <td width="16%" align="center" class="t-top3">Action</td>-->
                            </tr>
                           <?php foreach($businessList as $key=>$val){?> 
                            <tr>
                                <td class="t-top1" align="center">
                                    <?php 
                                    if($val['bussStatus']=='Active')                                    
                                        echo anchor('home/business_details/'.$val['buss_id'],img(array('src'=>base_url().'LOGO/'.$val['buss_logo'],'style'=>'float:left; width:100px; height:100px;')));
                                    else
                                        echo img(array('src'=>base_url().'LOGO/'.$val['buss_logo'],'style'=>'float:left; width:100px; height:100px;'));?>
                                </td>
                                <td class="t-top1" align="center">
                                    <?php 
                                    if($val['bussStatus']=='Active')
                                        echo anchor('home/business_details/'.$val['buss_id'],$val['buss_name']);
                                    else    
                                        echo $val['buss_name'];?>
                                </td>                                
                                <td class="t-top1" align="center"><?php echo _getBusinessCategoryNameString($val['buss_id']);?></td>                                
                                <td class="t-top1" align="center"><?php echo $val['bussStatus'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['bussUpdatedOn'];?></td>
                                <td class="t-top1" align="center">
                                   <a class="" href="<?php echo site_url('dashboard/business_listing/view/'.$val['buss_id']);?>" title="View details"><img src="<?php echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign"/></a>
                                   | <a class="" href="<?php echo site_url('dashboard/business_listing/edit/'.$val['buss_id']);?>" title="Edit details"><img src="<?php echo USER_SIDE_IMAGES.'edit.png'?>" class="imgMiddleAlign"/></a>
                                   | <a class="" href="<?php echo site_url('dashboard/business_listing/delete/'.$val['buss_id']);?>" title="Delete details" onclick="javascript: return confirm('Do you wants to delete this business?');"><img src="<?php echo USER_SIDE_IMAGES.'delete.png'?>" class="imgMiddleAlign"/></a>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>                   






<!-- popup start   -->             

<!--  popup end-->
                    
                    
 <!-- popup start FOR EDIT  -->             

<!--  popup end-->  
                </div>
            </section>
        </div>
    </div>
</div>