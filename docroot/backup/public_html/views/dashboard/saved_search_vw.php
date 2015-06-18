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
                   <div class="main-t">
                    <?php
           			 $attr = array('name' => 'frmdeleteselected', 'id' => 'frmdeleteselected', 'autocomplete' => 'off', 'method' => 'post');
          			  echo form_open('dashboard/saved_search/delete_selected', $attr);
           			 ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="5%" align="center" class="t-top3 selected" ><input name="chkall" id="chkall" type="checkbox" class="checkall" onclick="sss()"/></td>
                                <td width="8%" class="t-top3" align="center">sr.No</td>
                                <td width="30%" align="center" class="t-top3">Search term</td>
                                <td width="15%" align="center" class="t-top3">From Page</td>
                                <td width="20%" align="center" class="t-top3">Search date</td> 
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                           <?php $count=1;
						   foreach($searchList as $key=>$val){?> 
                            <tr>
                            	<td class="t-top1 selected" align="center"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['srhId'];?>"  class="chkmsg"/></td>
                                <td class="t-top1" align="center"><?php echo $count;?></td>
                                <td class="t-top1" align="center"><?php echo $val['srhKeywords'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['sthFromPage'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['srhCreatedOn'];?></td>
                                <td class="t-top1" align="center">
                                    <?php $delete_url='dashboard/saved_search/delete/'.$val['srhId'];?>
       		                        <?php  echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
                                </td>
                              
                            </tr>
                           
                            <?php  $count++;  }?>
                           
                        </table>
                        
					 </div>  
                      <input type="submit" id="submitForm" value="" style="display:none;"/>
                      <a href="#" class="button7" onclick="javascript: return $('#submitForm').click(); return false;">Delete Selected</a>
                        <?php echo form_close(); ?>  
				</div>
			</section>
          </div>
	</div>
</div>
