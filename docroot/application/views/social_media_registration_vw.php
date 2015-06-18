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
                <h1>Social Media Registration</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | Social Media Registration
                </div>
            </section></div>


        <div class="dash"><section id="main">               
                <div class="dash-r">                   
                    <div class="dash-form">
                        <?php
                    $attr = array('name' => 'frmSocialRegister', 'id' => 'frmSocialRegister', 'autocomplete' => 'off', 'method' => 'post');
                    echo form_open('social_signin/register', $attr);
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
                                <label>User Name*</label>
                                <input type="text" class="inp" name="user_name" id="user_name" value="<?php echo set_value('user_name', $user_name); ?>"/>
                                <?php echo form_error('user_name'); ?>
                            </div>
                            
                             <div class="dash-inner">
                                <label>Email *</label>
                                <input type="text" class="inp" name="user_email" id="user_email" value="<?php echo set_value('user_email', $user_email); ?>"/>
                                <?php echo form_error('user_email'); ?>
                            </div> 
                            
                             <div class="dash-inner">
                                <label>Password *</label>
                                <input type="password" class="inp" name="user_password" id="user_password" value="<?php echo set_value('user_password'); ?>"/>
                                <?php echo form_error('user_password'); ?>
                            </div> 
                            
                             <div class="dash-inner">
                                <label>Confirm Password *</label>
                                <input type="password" class="inp" name="c_password" id="c_password" value="<?php echo set_value('c_password');?>"/>
                                <?php echo form_error('c_password'); ?>
                            </div> 
                            <div class="dash-inner">                               
                                <!--<input type="button" class="dash-button" value="CLEAR FORM">-->
                                <input type="submit" class="dashorange" value="submit">
                                
                            </div>
                            
                        </div>
                        </form>
                    </div>
                </div>
            </section></div>
    </div>
</div>