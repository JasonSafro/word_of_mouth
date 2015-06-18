<script>
    function print_state(state_id, countryCode){ 
             $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>admin/user/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                   
                                });  
                                 $('#userState').selectmenu();
                              /*  $('#userState').parent().children(':not(#userState)').remove();
                                $('#userState').selectbox();*/
                    }
            });
           
        }  
        
         function print_state1(state_id, countryCode){ 
             $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>admin/user/getState/'+countryCode+"/"+<?php echo $user_id?>,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                              //  option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                   
                                });  
                               $('#userState').selectmenu();                              
                    }
            });
           
        }     
        
              
        </script>
<script>
        $(document).ready(function() {
        
         //When Page Loads- Get State by country
            var e = document.getElementById("userCountry");
            if(e!=''){
            var strUser = e.options[e.selectedIndex].value;                          
            print_state1('userState',strUser);}
            else{
            print_state('userState',strUser);}
               
          //When Country Changes, Change State
        $('#userCountry').change(function(){
            
              var e = document.getElementById("userCountry");
                           var strUser = e.options[e.selectedIndex].value;                          
                           print_state('userState',strUser);            
                       /*setTimeout(function(){
                           var e = document.getElementById("userCountry");
                           var strUser = e.options[e.selectedIndex].value;                          
                           print_state('userState',strUser);
                       },500)*/
                        });
        
        });
</script>


<!-- content -->
<?php echo js_asset('smooth.form.js');?>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> User</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewUser', 'id' => 'frmNewUser', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/user/add_new/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/user/edit/'.$user_id.'/'.$sort_by.'/'.$sort_type.'/'.$offset.'/N';
                    echo form_open($form_url1, $attr1);
                    ?>
                <input class="input" name="userId" type="hidden" value="<?php echo $user_id;?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">User Name:</label>
                            </div>
                            <div class="input">
                                <input name="user_name" id="user_name" value="<?php echo set_value('user_name',$user_name);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('user_name');?>
                            </div>
                        </div>     

                        <div class="field">
                            <div class="label">
                                <label for="input-large">First Name:</label>
                            </div>
                            <div class="input">
                                <input name="user_fname" id="user_fname" value="<?php echo set_value('user_fname',$user_fname);?>" type="text" maxlength="30" size="50"/>
                                <?php echo form_error('user_fname');?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Last Name:</label>
                            </div>
                            <div class="input">
                                 <input name="user_lname" id="user_lname" value="<?php echo set_value('user_lname',$user_lname);?>" type="text" maxlength="30" size="50"/>
                                <?php echo form_error('user_lname');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email:</label>
                            </div>
                            <div class="input">
                                <input name="user_email" id="user_email" value="<?php echo set_value('user_email',$user_email);?>" type="text" maxlength="60"  size="50"/>
                                <?php echo form_error('user_email');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Password:</label>
                            </div>
                            <div class="input">
                                <input name="user_password" id="user_password" value="<?php echo set_value('user_password');?>" type="password" maxlength="60" size="50" placeholder="Click Here To Change The Password"/>
                                <?php echo form_error('user_password');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone Number:</label>
                            </div>
                            <div class="input">
                                <input name="user_phone" id="user_phone" value="<?php echo set_value('user_phone',$user_phone);?>" type="text" maxlength="15" size="50"/>
                                <?php echo form_error('user_phone');?>
                            </div>
                        </div>                                                
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">City:</label>
                            </div>
                            <div class="input">
                                <input name="user_city" id="user_city" value="<?php echo set_value('user_city',$user_city);?>" type="text" maxlength="60" size="50"/>
                                <?php echo form_error('user_city');?>
                            </div>
                        </div>
                        
                          <div class="field">
                            <div class="label">
                                <label for="input-large">Country:</label>
                            </div>
                            <div class="input">
                               <select name="Items" id="userCountry">
                                    <?php
                                         $countryList = _getCountryList();    
                                         if ($user_country)
                                            {
                                                foreach ($countryList as $key => $val)
                                                {
                                                    if ($key == $user_country)
                                                    {
                                                        ?>
                                                    <option value="<?php echo $key; ?>" selected><?php echo $val; ?></option> 
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="' . $key . '">' . $val . ' </option> ';
                                                    }
                                                }
                                            }
                                            else
                                            { 
                                                foreach ($countryList as $key => $val)
                                                {
                                              ?>                                           
                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>                                            
                                        <?php }} ?>                                 
                                </select>
                                 <?php echo form_error('Items');?>
                            </div>
                        </div>
                        
                          <div class="field">
                            <div class="label">
                                <label for="input-large">State:</label>
                            </div>
                            <div class="input">                                
                                <select name="userState" id="userState">
                                    <option>Choose your state</option>
                                </select> 
                                 <?php echo form_error('userState');?>
                                </div>
                        </div>
                        
                        
                        <?php if($user_plan != ''){?>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">User Plan:</label>
                            </div>
                           <div class="input"><br/><?php
                            if ($user_plan == 'bm')
                                echo $basic_plan_name . " " . $basic_plan_monthly_name;
                            else if ($user_plan == 'ba')
                                echo $basic_plan_name . " " . $basic_plan_annual_name;
                            else if ($user_plan == 'pm')
                                echo $prem_plan_name . " " . $prem_plan_monthly_name;
                            else if ($user_plan == 'pa')
                                echo $prem_plan_name . " " . $prem_plan_annual_name;
                            else
                                echo "N/A";
                            ?></div>
                        </div>
                        <?php }?>
                        <div style="clear:both;"></div>
                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/user";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/user/', 'Back'); ?>
                                </span>
                            </div>
                        </div-->
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>
            
           
            
            <!-- Business Information End-->
            
            
        </div>
        <!-- end table -->
        <!-- end box / right -->
    </div>
    <!-- end content / right -->
</div>