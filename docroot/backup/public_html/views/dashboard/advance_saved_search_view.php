<script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script>
<script>
function sss(){

     if ($('#chkall').is(':checked')) {
          $('.chkmsg').attr('checked', 'checked');           
     }
     else {
          $('.chkmsg').removeAttr('checked');
     }
   }
</script>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Saved search
                </div>
            </section></div>


        <div class="dash">
         <section id="main">
<?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                     <?php echo $this->load->view('success_error_message_area');?>
                   <div class="main-t">
                    <?php
           			 $attr = array('name' => 'frmdeleteselected', 'id' => 'frmdeleteselected', 'autocomplete' => 'off', 'method' => 'post');
					 //dashboard/advance_saved_search/delete_selected
					 
          			  echo form_open('advance_search/do_search', $attr);
           			 ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="5%" align="center" class="t-top3 selected" ><input name="chkall" id="chkall" type="checkbox" class="checkall" onClick="sss()"/></td>
                                
                                <td width="30%" align="center" class="t-top3">Zip</td>
                                <td width="30%" align="center" class="t-top3">Country</td>
                                <td width="15%" align="center" class="t-top3">State</td>
                                <td width="20%" align="center" class="t-top3">City</td> 
                                <td width="20%" align="center" class="t-top3">Radius</td> 
                                <td width="20%" align="center" class="t-top3">Image?</td> 
                                <td width="20%" align="center" class="t-top3">Video?</td> 
                                <td width="20%" align="center" class="t-top3">Info?</td> 
                                <td width="20%" align="center" class="t-top3">Offers?</td> 
                                <td width="20%" align="center" class="t-top3">Rating</td> 
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                           <?php $count=1;
						  
						   foreach($searchList as $key=>$val){
						    if($val!='' || $val!=0){
						   ?> 
                           <input name="country" id="country" type="hidden" value="<?php echo $val['country'];?>"  class="chkmsg"/>
                           <input name="zip_code" id="zip_code" type="hidden" value="<?php echo $val['zip_code'];?>"  class="chkmsg"/>
                           <input name="state" id="state" type="hidden" value="<?php echo $val['state'];?>"  class="chkmsg"/>
                           <input name="city" id="city" type="hidden" value="<?php echo $val['city'];?>"  class="chkmsg"/>
                           <input name="radius" id="radius" type="hidden" value="<?php echo $val['radius'];?>"  class="chkmsg"/>
                           <input name="hasImage" id="hasImage" type="hidden" value="<?php echo $val['hasImage'];?>"  class="chkmsg"/>
                           <input name="hasVideo" id="hasVideo" type="hidden" value="<?php echo $val['hasVideo'];?>"  class="chkmsg"/>
                           <input name="additional_info" id="additional_info" type="hidden" value="<?php echo $val['additional_info'];?>"  class="chkmsg"/>
                           <input name="hasOffers"  id="hasOffers" type="hidden" value="<?php echo $val['hasOffers'];?>"  class="chkmsg"/>
                           <input name="minRating" id="minRating" type="hidden" value="<?php echo $val['minRating'];?>"  class="chkmsg"/>
                            <tr>
                            	<td class="t-top1 selected" align="center">
                                <input name="chkmsg[]" type="checkbox" value="<?php echo $val['search_id'];?>" id="chkmsg[]" class="chkmsg" /></td>
                               
                                <td class="t-top1" align="center"><?php echo $val['zip_code'];?></td>
                                <td class="t-top1" align="center"><?php 
								 $countryList= _getCountry_name($val['country']);
								
								echo $countryList;?></td>
                                <td class="t-top1" align="center"><?php
								$state = _getState_name($val['country'],$val['state']);
								
								 echo $state;?></td>
                                <td class="t-top1" align="center"><?php echo $val['city'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['radius'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['hasImage'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['hasVideo'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['additional_info'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['hasOffers'];?></td>
                                <td class="t-top1" align="center"><?php echo ($val['minRating']==0?"--":$val['minRating']);?></td>
                                
                                <td class="t-top1" align="center">
                                
                                 <!--<a class=""  title="View details" onClick="let_search();"><img src="<?php //echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign" /></a>-->
                                 <input type="image" src="<?php echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign" />

                                <?php $delete_url='dashboard/advance_saved_search/delete/'.$val['search_id'];?>
                                <?php  echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "javascript: return confirm('Do you want to delete this?');")); ?>
                                </td>
                              
                            </tr>
                           
                            <?php  $count++; } }?>
                           
                        </table>
                        
					 </div>  
                   <!--   <input type="submit" id="submitForm" value="" style="display:none;"/>-->
                    <div class="clear" style="margin-bottom: 10px;"></div>
                      <a href="javascript:void(0);" class="button7" onclick="let_search();">Delete Selected</a>
                        <?php echo form_close(); ?>  
				</div>
			</section>
          </div>
	</div>
</div>
</body>
</html>


<script type='text/javascript'>

function let_search() {

 var selected_val = new Array();
        $('input:checkbox[name^="chkmsg"]:checked').each(function(){
            
            selected_val.push($(this).attr('value'));
        });

$.ajax({
    type: 'POST',
   url: '<?php echo site_url('dashboard/advance_saved_search/delete_selected'); ?>',
   dataType: 'json',
   data: {chkmsg:selected_val,send:'post'},
    cache: false,
    success: function(result) {
	if(result=true)
	{
	 	var url="<?php echo site_url('dashboard/advance_saved_search'); ?>";
        window.location.href=url;
    } 
	 }
      });
    
}
</script>