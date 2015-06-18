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
        
        $("#dealExpirationDate").datepicker({		
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            changeYear: true
        });
        
        $("#EdealExpirationDate").datepicker({		
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
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
            duration: 2000 
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
    
    // if user is editing a deal and has refreshed a page then this code will work.
    var currentEditDealId="<?php echo $this->session->userdata('currentEditDealId');?>";
    if(currentEditDealId!="" && currentEditDealId!=null)
    {
        var errorLen='<?php echo strlen(validation_errors());?>';
        if(errorLen=='0')
            getDeal(currentEditDealId);
    }    
    
    function getDeal(dealId)
    {
        
        //alert(dealId);
        $.ajax({
                type: "GET",                                        
                url: '<?php echo base_url() ?>dashboard/deals/getDeal/'+dealId,
                dataType:"json",
                success: function (data) {
                        $('#EdealBusinessId').val(data['dealBusinessId']);               
                        $('#EdealOverview').val(data['dealOverview']);               
                        $('#EdealDetails').val(data['dealDetails']);               
                        $('#EdealValue').val(data['dealValue']);               
                        $('#EdealDiscounts').val(data['dealDiscounts']);               
                        $('#EdealSavings').val(data['dealSavings']);               
                        $('#EdealFinalPrice').val(data['dealFinalPrice']);               
                        $('#EdealExpirationDate').val(data['dealExpirationDate']);               
                        $('#EdealLimit').val(data['dealLimit']);               
                        $('#EdealId').val(dealId);    
                        
                        var dealImagePath="<?php echo base_url().'/sitedata/images/deal_images';?>";
                        $('#editDealImage').attr('src',dealImagePath+'/'+data['dealImage']);
                        //alert(t);
                }
            });//EdealExpirationDate
    }
</script>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Deals & Coupons
                </div>
            </section></div>


        <div class="dash">
            
            <section id="main">
<?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="post-right"><a class="button4" href="#address11" id="address_pop">New Deal</a></div>

                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%" class="t-top3"align="center">Business Name</td>
                                <td width="35%" align="center" class="t-top3">Deal Overview</td>
                                <td width="10%" align="center" class="t-top3">Value</td>
                                <td width="10%" align="center" class="t-top3">Discount</td>                                
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                           <?php foreach($dealList as $key=>$val){?> 
                            <tr>
                                <td class="t-top1"align="center"><?php echo $val['buss_name'];?></td>
                                <td class="t-top1"align="center"><?php echo $val['dealOverview'];?></td>
                                <td class="t-top1"align="center">$<?php echo $val['dealValue'];?></td>
                                <td class="t-top1"align="center"><?php echo $val['dealDiscounts'];?>%</td>
                                <td class="t-top1"align="center"><a class="" href="#dealEdit" id="dealEdit_pop" onclick="getDeal(<?php echo $val['dealId'];?>);"><img src="<?php echo USER_SIDE_IMAGES.'edit.png'?>" class="imgMiddleAlign"/></a> &nbsp;|&nbsp;
                                <a onclick="javascript: return confirm('Do you wants to delete this deal?');" title="Delete deal" href="<?php echo site_url('dashboard/deals/delete/'.$val['dealId']);?>" class=""><img class="imgMiddleAlign" src="<?php echo USER_SIDE_IMAGES.'delete.png'?>"></a>
                                </td>
                                <!--td class="t-top1"align="center"><div class="post-right"><a class="button4" href="#dealEdit" id="dealEdit_pop" onclick="getDeal(<?php echo $val['dealId'];?>);">Edit</a></div></td-->
                            </tr>
                            <?php }?>
                        </table>



                    </div>                   






                    <!-- popup start   -->             
                    <div> <a href="#" class="overlay" id="address11"></a>
                        <div class="address-popup">
                            <div class="popup-title"><a class="close" href="#close"></a> </div>
                            <div class="content-pop" align="center">
                                <h1>Post Deal </h1>
                                <h2> Your deal will be reviewed & posted</h2>
                                <div class="form1">
                                    <?php
                                        $attr = array('name' => 'frmDealAddEdit', 'id' => 'frmDealAddEdit', 'autocomplete' => 'off', 'method' => 'post');
                                        echo form_open_multipart('dashboard/deals/new_deal#address11', $attr);
                                        ?>
                                        <div class="write">
                                            <div class="write-first">
                                                <h4>Deal Information</h4>
                                            </div>
                                            <div class="write-second">
                                                <h4>&nbsp;</h4>

                                            </div>
                                            <div class="clear"></div>
                                            
                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Business Name *</label>
                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                 <?php echo form_dropdown('dealBusinessId',__myBusinessDropdown($user_id),set_value('dealBusinessId'),'id="dealBusinessId"');?>
                                                 <?php echo form_error('dealBusinessId'); ?>
                                            </div>
                                            
                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Overview</label>
                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                <textarea name="dealOverview" id="dealOverview" cols="" rows="6" class="top-mr"><?php echo set_value('dealOverview'); ?></textarea>
                                                <?php echo form_error('dealOverview'); ?>
                                                
                                            </div>
                                            <div class="clear"></div>

                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Details</label>
                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                <textarea name="dealDetails" id="dealDetails" cols="" rows="6" class="top-mr"><?php echo set_value('dealDetails'); ?></textarea>
                                            <?php echo form_error('dealDetails'); ?>
                                            </div>

                                            
                                            <div class="write-first">
                                                <label>Value</label>
                                               <input type="text" name="dealValue" id="dealValue" value="<?php echo set_value('dealValue'); ?>" maxlength="10"/>
                                               <?php echo form_error('dealValue'); ?>
                                            </div>
                                            <div class="write-second">
                                                <label>Discount</label>
                                                <input type="text" name="dealDiscounts" id="dealDiscounts" value="<?php echo set_value('dealDiscounts'); ?>"  maxlength="10" />
                                                <?php echo form_error('dealDiscounts'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="write-first">

                                                <label>Savings</label>
                                                <input type="text" name="dealSavings" id="dealSavings" value="<?php echo set_value('dealSavings'); ?>"  maxlength="10"/>
                                               <?php echo form_error('dealSavings'); ?>
                                            </div>
                                            <div class="write-second">

                                                <label>Final Price</label>
                                                <input type="text" name="dealFinalPrice" id="dealFinalPrice" value="<?php echo set_value('dealFinalPrice'); ?>"  maxlength="10"/>
                                               <?php echo form_error('dealFinalPrice'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="write-first">
                                                <label>Expiration Date</label>
                                                <input type="text" name="dealExpirationDate" id="dealExpirationDate" readonly="true" value="<?php echo set_value('dealExpirationDate'); ?>"/>
                                                <?php echo form_error('dealExpirationDate'); ?>
                                            </div>
                                            <div class="write-second">

                                                <label>Limit</label>
                                                <input name="dealLimit" type="text" id="dealLimit" value="<?php echo set_value('dealLimit'); ?>" />
                                                <?php echo form_error('dealExpirationDate'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            
                                            
                                            <div class="write-first">
                                                <label>Select Image *</label>
                                                <input name="dealImage" id="dealImage" type="file" value=""/>
                                                (Tip:Min Width:361,Min Height:214)
                                                <div style="float:left; clear: both; margin-top: 5px;"></div>
                                                <?php echo ($newImageError!=""?'<span class="error">'.$newImageError.'</span>':'')?>
                                            </div>
                                            
                                           <div class="write-second">
                                                <label>Select Document(.pdf file only)*</label>
                                                <input name="dealDocument" id="dealDocument" type="file" value=""/>
                                                <?php echo ($newDealDocumentError!=""?'<span class="error">'.$newDealDocumentError.'</span>':'');?>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                        <div class="clear"></div>
                                        <div class="post-right">
                                            <a href="#" onclick="javascript: return $('#submitNewDealForm').click(); return false;"><img src="<?php echo USER_SIDE_IMAGES; ?>submit3.png"></a>
                                        </div>
                                        <input type="submit" id="submitNewDealForm" value="" style="display:none;"/>
                                        </br></br></br></br></br></br></br></br>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--popup end-->
                    
                    
                    <!-- popup start   -->             
                    <div> <a href="#" class="overlay" id="dealEdit"></a>
                        <div class="address-popup">
                            <div class="popup-title"><a class="close" href="#close"></a> </div>
                            <div class="content-pop" align="center">
                                <h1>Post Deal </h1>
                                <h2> Your deal will be reviewed & posted</h2>
                                <?php //echo validation_errors('<div class="error">', '</div>'); ?>
                                <div class="form1">
                                    <?php
                                        $attr = array('name' => 'frmDealAddEdit', 'id' => 'frmDealAddEdit', 'autocomplete' => 'off', 'method' => 'post');
                                        echo form_open_multipart('dashboard/deals/edit/#dealEdit', $attr);
                                        ?>
                                    <input type="hidden" name="dealId" id="EdealId" value="<?php echo set_value('dealId'); ?>"/>
                                        <div class="write">
                                            <div class="write-first">
                                                <h4>Deal Information</h4>
                                            </div>
                                            <div class="write-second">
                                                <h4>&nbsp;</h4>

                                            </div>
                                            <div class="clear"></div>
                                            
                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Business Name *</label>

                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                 <?php echo form_dropdown('dealBusinessId',__myBusinessDropdown($user_id),set_value('dealBusinessId'),'id="EdealBusinessId"');?>
                                                 <?php echo form_error('dealBusinessId'); ?>
                                            </div>
                                            
                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Overview</label>
                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                <textarea name="dealOverview" id="EdealOverview" cols="" rows="6" class="top-mr"><?php echo set_value('dealOverview'); ?></textarea>
                                                <?php echo form_error('dealOverview'); ?>
                                                
                                            </div>
                                            <div class="clear"></div>

                                            <div class="write">
                                                <div class="write-first">
                                                    <label>Details</label>
                                                </div>
                                                <div class="write-second">
                                                    &nbsp;
                                                </div>
                                                <div class="clear"></div>
                                                <textarea name="dealDetails" id="EdealDetails" cols="" rows="6" class="top-mr"><?php echo set_value('dealDetails'); ?></textarea>
                                            <?php echo form_error('dealDetails'); ?>
                                            </div>

                                            
                                            <div class="write-first">

                                                <label>Value</label>
                                               <input type="text" name="dealValue" id="EdealValue" value="<?php echo set_value('dealValue'); ?>"  maxlength="10" />
                                               <?php echo form_error('dealValue'); ?>
                                            </div>
                                            <div class="write-second">

                                                <label>Discount</label>
                                                <input type="text" name="dealDiscounts" id="EdealDiscounts" value="<?php echo set_value('dealDiscounts'); ?>"  maxlength="10"/>
                                                <?php echo form_error('dealDiscounts'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="write-first">

                                                <label>Savings</label>
                                                <input type="text" name="dealSavings" id="EdealSavings" value="<?php echo set_value('dealSavings'); ?>"  maxlength="10"/>
                                               <?php echo form_error('dealSavings'); ?>
                                            </div>
                                            <div class="write-second">

                                                <label>Final Price</label>
                                                <input type="text" name="dealFinalPrice" id="EdealFinalPrice" value="<?php echo set_value('dealFinalPrice'); ?>"  maxlength="10" />
                                               <?php echo form_error('dealFinalPrice'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="write-first">

                                                <label>Expiration Date</label>
                                                <input type="text" name="dealExpirationDate" id="EdealExpirationDate" readonly="true" value="<?php echo set_value('dealExpirationDate'); ?>"/>
                                                <?php echo form_error('dealExpirationDate'); ?>
                                            </div>
                                            <div class="write-second">

                                                <label>Limit</label>
                                                <input name="dealLimit" type="text" id="EdealLimit" value="<?php echo set_value('dealLimit'); ?>" />
                                                <?php echo form_error('dealExpirationDate'); ?>
                                            </div>
                                            <div class="clear"></div>
                                            
                                            
                                            <div class="write-first">
                                                <label>Select Image* </label>
                                                <input name="dealImage" id="EdealImage" type="file" value=""/><br/>                                                
                                                (Tip:Min Width:361,Min Height:214)
                                                <?php echo ($editImageError!=""?'<span class="error" style="float:left;">'.$editImageError.'</span>':'');
                                                //echo img(array('src'=>base_url().'/sitedata/images/deal_images/' ,'style'=>'float:left; width:100px; height:100px;')); ?>
                                                <div style="float:left; clear: both; margin-top: 5px;"></div>
                                                <img id="editDealImage" src="<?php echo base_url().'/sitedata/images/deal_images/';?>" style="float:left; width:100px; height:100px;"/>
                                            </div>
                                            <div class="write-second">
                                                <label>Select Document(.pdf file only)*</label>
                                                <input name="dealDocument" id="EdealDocument" type="file" value=""/>
                                                <?php echo ($editDealDocumentError!=""?'<span class="error">'.$editDealDocumentError.'</span>':'');?>
                                            </div>
                                            
                                        </div>
                                        <div class="clear"></div>
                                        <div class="post-right">
                                            <a href="#" onclick="javascript: return $('#submitEditDealForm').click(); return false;"><img src="<?php echo USER_SIDE_IMAGES; ?>submit3.png"></a>
                                        </div>
                                        <div class="clear"></div>
                                        <input type="submit" id="submitEditDealForm" value="" style="display:none;"/>
                                        </br></br></br></br></br></br></br></br>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--popup end-->








                </div>




            </section></div>






    </div>
</div>

<?php

if($error_occured == "y"){
?>
	
	<script>
	
		  
	    window.location.href = "#address11";

	</script>
	<?php
}
?>