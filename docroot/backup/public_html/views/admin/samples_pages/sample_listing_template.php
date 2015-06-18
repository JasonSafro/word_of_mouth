<!-- content -->

<script type="text/ecmascript" language="javascript">
function add_user()
{
	window.location.href='<?php echo site_url().'/admin/manageuser/create_user'?>';
}

function no_records()
{
	document.userfrm.action="<?php echo base_url(); ?>index.php/admin/user/userlist";
	document.userfrm.submit();
}

</script>
<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Registered User's</h5>
        <div class="search">
          <form action="#" method="post">
            <div class="input">
              <input type="text" id="search" name="search" />
            </div>
            <div class="button">
              <input type="submit" name="submit" value="Search" />
            </div>
          </form>
        </div> 
      </div>
      <!-- end box / title -->
	  <?php 	$attributes = array('name' => 'frmuser', 'id' => 'frmuser');
				echo form_open('admin/user/userlist', $attributes);
		 ?>
					   <div class="table">
		 				<table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
							<thead>
                            <tr>
                            <th width="4%" align="center" class="selected" style="background: #E6EEEE;">
							<input type="checkbox" class="checkall" /></th>
                            <th width="9%" align="left">First Name</th>
                            <th width="9%" align="left">Last Name</th>
                            <th width="15%" align="left">Email Address</th>
                            <th width="6%" align="left">City</th>
                            <th width="7%" align="left">Country</th>
                            <th width="17%" align="left">Registered Date</th>
                            <th width="20%" align="left">Last Login Date</th> 									
                            <th width="26%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
							</thead>
							<tbody>
								<tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>test</td>
                                    <td>test<td>
                                    <td>test@hotmail.com</td>
                                    <td>test</td>
                                    <td>India</td>
                                    <td>April 25th, 2013 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                    <td>Edit / Delete</td>
					    		</tr>
                                <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Rajesh</td>
                                    <td>Patil</td>
                                    <td>Patilraj21@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
                                <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Rajesh</td>
                                    <td>Patil</td>
                                    <td>Patilraj21@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
                                <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Rajesh</td>
                                    <td>Patil</td>
                                    <td>Patilraj21@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
                                <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Rajesh</td>
                                    <td>Patil</td>
                                    <td>Patilraj21@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
								 <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Rajesh</td>
                                    <td>Patil</td>
                                    <td>Patilraj21@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
                                 <tr>
                                    <td class="selected"><input type="checkbox" /></td>
									<td>Kushal</td>
                                    <td>mogre</td>
                                    <td>Kushal@hotmail.com</td>
                                    <td>Dhule</td>
                                    <td>India</td>
                                    <td>April 25th, 2010 at 4:15 PM</td>
                                    <td>November 25th, 2010 at 4:15 PM</td>
                                     <td>Edit / Delete</td>
					    		</tr>
                                
                                
							</tbody>
						</table>
						<!-- pagination -->
						<div class="pagination pagination-left">
							<div class="results">

								<span>showing results 1-10 of 207</span>
							</div>
							<ul class="pager">
								<li class="disabled">&laquo; prev</li>
								<li class="current">1</li>
								<li><a href="">2</a></li>

								<li><a href="">3</a></li>
								<li><a href="">4</a></li>
								<li><a href="">5</a></li>
								<li class="separator">...</li>
								<li><a href="">20</a></li>
								<li><a href="">21</a></li>

								<li><a href="">next &raquo;</a></li>
							</ul>
						</div>
						<!-- end pagination -->
						<!-- table action -->
						<div class="action">
							<select name="action">
                           	 <option value="" class="">Set status </option>
								<option value="" class="locked">Set status to Deleted</option>
 								<option value="" class="unlocked">Set status to Published</option>
								<!--<option value="" class="folder-open">Move to Category</option>-->
							</select>
							<div class="button">
								<input type="submit" name="submit" value="Apply to Selected" />
							</div>
						</div>
						<!-- end table action -->
 
	  </div>
    </div>
	<?php echo form_close(); ?>
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
