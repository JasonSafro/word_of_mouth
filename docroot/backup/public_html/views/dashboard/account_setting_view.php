<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.selectbox-0.2.js"); ?>
<script type="text/javascript">
    $(function () {
      //  $("#userCountry").selectbox();
       // $("#userState").selectbox();
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
<script>
    function print_state(state_id, countryCode){ 
             $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>dashboard/manage_account/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                   
                                });  
                                // $('#userState').selectmenu();                              
                    }
            });
           
        }  
        
        
         function print_state1(state_id, countryCode){ 
             $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>dashboard/manage_account/getState/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                              //  option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                   
                                });  
                                // $('#userState').selectmenu();                              
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
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/manage_account">Dashboard</a> | Account
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">  
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="dash-form">
                        <?php
                    $attr = array('name' => 'frmUserInfoEdit', 'id' => 'frmUserInfoEdit', 'autocomplete' => 'off', 'method' => 'post');
                    echo form_open('dashboard/manage_account', $attr);
                    ?>
                        <div class="dash-area">	
                            <div class="dash-inner">
                                <label>First Name *</label>
                                <input type="text" class="inp" name="user_fname" id="user_fname" value="<?php echo set_value('user_fname', $user_fname); ?>"/>
                                  <?php echo form_error('user_fname'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Last Name *</label>
                                <input type="text" class="inp" name="user_lname" id="user_lname" value="<?php echo set_value('user_lname', $user_lname); ?>"/>
                                <?php echo form_error('user_lname'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Address*</label>
                                <input type="text" class="inp" name="user_address" id="user_address" value="<?php echo set_value('user_address', $user_address); ?>"/>
                                <?php echo form_error('user_address'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Address Add On</label>
                                <input type="text" class="inp" name="user_address_addon" id="user_address_addon" value="<?php echo set_value('user_address_addon', $user_address_addon); ?>"/>
                             <?php echo form_error('user_address_addon'); ?>
                            </div>
                             <div class="dash-inner">
                                <label>Phone *</label>
                                <input type="text" class="inp" name="user_phone" id="user_phone" value="<?php echo set_value('user_phone', $user_phone); ?>"/>
                                <?php echo form_error('user_phone'); ?>
                            </div> 
                            <div class="dash-inner">
                                <label>City *</label>
                                <input type="text" class="inp" name="user_city" id="user_city" value="<?php echo set_value('user_city', $user_city); ?>"/>
                                <?php echo form_error('user_city'); ?>
                            </div>
                             <!--<div class="dash-inner">
                                  <label>Country *</label>
                                  <input type="text" class="inp" name="user_country" id="user_country" value="<?php echo set_value('user_country', $user_country); ?>"/>
                                  <?php echo form_error('user_country'); ?>
                             </div>    -->                       
                              <div class="dash-inner">                            
                                <label>Country *</label>                           
                                <div>
                                     <select name="Items" id="userCountry" class="inp">                                      
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
                                    <?php echo form_error('Items'); ?>
                                </div>
                            </div>                        
                            <div class="dash-inner">                           
                                <label>State *</label>
                                <select name="userState" id="userState" class="inp">
                                    <option value="">Choose your state</option>
                                </select> 
                                <?php echo form_error('userState'); ?>
                            </div>
                           <!-- <div class="dash-inner">
                                <label>State*</label>
                                <input type="text" class="inp" name="user_state" id="user_state" value="<?php echo set_value('user_state', $user_state); ?>"/>
                                <?php echo form_error('user_state'); ?>
                            </div>-->
                            <div class="dash-inner">
                                <label>Zip Code *</label>
                                <input type="text" class="inp" name="user_zipcode" id="user_zipcode" value="<?php echo set_value('user_zipcode', $user_zipcode); ?>"/>
                                <?php echo form_error('user_zipcode'); ?>
                            </div>                             
                            <div class="dash-inner">                               
                                <!--<input type="button" class="dash-button" value="CLEAR FORM">-->
                                <input type="submit" class="dashorange" value="submit">
                                
                            </div>
                            <div class="dash-inner"> 
                           <?php echo anchor('dashboard/account_overview', 'Back','class="dashorange" title="Back"');?>
                                 </div>
                        </div>
                        </form>
                    </div>
                </div>
            </section></div>
    </div>
</div>