<?php echo js_asset("jquery.selectbox-0.5.js");  ?>
<link href="<?php echo base_url();?>assets/datepicker/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script>


<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
		//select box
                $('#dealBusinessId').selectbox();
                
		var currentTime = new Date();
		var year =currentTime.getFullYear();
		var month=currentTime.getMonth();
		var cdate=currentTime.getDate();
		
		$("#dealExpirationDate").datepicker({		
		dateFormat: "yy-mm-dd",
		changeYear: true
		});
                
                
	});
</script>
<style>
    .red {
    color: #FF0000;
    font-size: 10px;
    font-style: italic;
    font-weight: bold;
}
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/Manage_business_info">Dashboard</a> | Business
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                   
                    <div class="dash-form">
                        <?php
                    $attr = array('name' => 'frmDealAddEdit', 'id' => 'frmDealAddEdit', 'autocomplete' => 'off', 'method' => 'post');
                    echo form_open('dashboard/deals/new_deal', $attr);
                    ?>
                        <div class="dash-area">	
                            
                            <div class="dash-inner">
                                <label>Business Name *</label>
                                <?php echo form_dropdown('dealBusinessId',__myBusinessDropdown($user_id),$dealBusinessId,'id="dealBusinessId"');?>
                                <?php echo form_error('dealBusinessId'); ?>
                            </div>
                            
                            <div class="dash-inner">
                                <label>Overview *</label>
                                <input type="text" class="inp" name="dealOverview" id="dealOverview" value="<?php echo set_value('dealOverview', $dealOverview); ?>"/>
                                <?php echo form_error('dealOverview'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Description *</label>
                                <textarea name="dealDetails" id="dealDetails" class="txtarea" rows="5"><?php echo set_value('dealDetails', $dealDetails); ?></textarea>                                
                                <?php echo form_error('dealDetails'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Deal Value *</label>
                                <input type="text" class="inp" name="dealValue" id="dealValue" value="<?php echo set_value('dealValue', $dealValue); ?>"/>
                             <?php echo form_error('dealValue'); ?>
                            </div>
                              <div class="dash-inner">
                                <label>Discount </label>
                                <input type="text" class="inp" name="dealDiscounts" id="dealDiscounts" value="<?php echo set_value('dealDiscounts', $dealDiscounts); ?>"/>
                                <?php echo form_error('dealDiscounts'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Expiry Date *</label>
                                <input type="text" class="inp" name="dealExpirationDate" id="dealExpirationDate" value="<?php echo set_value('dealExpirationDate', $dealExpirationDate); ?>"/>
                                <?php echo form_error('dealExpirationDate'); ?>
                            </div> 
                             <div class="dash-inner">
                                <label>Limits</label>
                                <textarea name="dealLimit" id="dealLimit" class="txtarea" rows="5"><?php echo set_value('dealLimit', $dealLimit); ?></textarea>                                
                                <?php echo form_error('dealLimit'); ?>
                            </div>
                                                        
                            <div class="dash-inner">
                                <!--<input type="button" class="dash-button" value="CLEAR FORM">-->
                                <input type="submit" class="dashorange" value="submit"/>
                                <input type="button" class="dashorange" value="Back" onclick="javascript: window.history.go(-1);"/>
                            </div>
                           
                        </div>
                        </form>
                    </div>
                </div>




            </section></div>






    </div>
</div>
