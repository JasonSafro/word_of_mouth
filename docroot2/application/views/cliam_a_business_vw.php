
<script src="<?php echo base_url()?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
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
    <div id="page-wrap">

        <div id="main1">
          <section class="inside-title">
              <div class="inside-title-in"><div  id="main">
              <h1>Claim a business | <?php echo $info['buss_name']?></h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> |  <?php echo anchor('home/business_details/'.$info['buss_id'],$info['buss_name']); ?> | Claim a business</div></div>
              </div>
          </section>
        </div>
        <div class="clear"></div>
 
      <div id="section">
        <section id="main">
            <div class="contact-main">
        <article class="section-left-inside-contact top-mar">
            <div class="dash"><?php echo $this->load->view('success_error_message_area');?></div>
            <h3>Claim a business</h3>
        <h4>Please fill in the below form to claim your business</h4>
        <div class="clear"></div>
         <?php 
        $attr = array('name' => 'frmClaimRequest', 'id' => 'frmClaimRequest', 'autocomplete' => 'off', 'method' => 'post');        
        echo form_open_multipart('claim/business/'.$info['buss_id'], $attr);
        ?>
        
        <label>Already have an account?</label>
        <input type="radio" name="haveAcccount" id="IhaveAccount" value="yes" style="width:auto !important;" onclick="hideShowUserInfo('show')" <?php echo set_radio('haveAcccount','yes');?>/> Yes
        <input type="radio" name="haveAcccount" id="IdontHaveAccount" value="no" style="width:auto !important;" onclick="hideShowUserInfo('hide')" <?php echo set_radio('haveAcccount','no');?>/> No
        <div class="clear"></div>    
        
        <div id="showOrHide">
        <label >Please enter your existing username or email address *</label>
        <input name="userName" type="text" value="<?php echo set_value('userName');?>"/><?php echo form_error('userName');?> 
        <label>Password *</label>
        <input name="userPassword" type="password" value="<?php echo set_value('userPassword');?>"/><?php echo form_error('userPassword');?> 
        </div>
        <label>Business phone number *</label><input name="crBussPhoneNo" type="text" value="<?php echo set_value('crBussPhoneNo');?>"/><?php echo form_error('crBussPhoneNo');?> 
        <label>Business official address *</label><input name="crBussOfficeAddress" type="text" value="<?php echo set_value('crBussOfficeAddress');?>"/><?php echo form_error('crBussOfficeAddress');?> 
        <label>Business official email address *</label><input name="crBussOfficialEmail" type="text" value="<?php echo set_value('crBussOfficialEmail');?>"/><?php echo form_error('crBussOfficialEmail');?> 
        <label>Any additional information (like registration number etc.)</label><textarea name="crBussAdditionalInfo" cols="" rows="7"></textarea><?php echo form_error('crBussAdditionalInfo');?>
        <div id="captch">
            <label>Enter the code Below :</label>
                    <?php if($cap_img){ echo $cap_img;}?>


                    <div id="error">
                    <?php if(isset($captcha_error)){ ?>
                          <span style="float:left;color: #EE0101 !important;"><?php if(isset($captcha_error))echo $captcha_error; ?></span>
                    <?php }?>		
                    </div>

             </div>
 
        <div class="conntact-buttons">
            <div class="tabs-contact">
                <div class="tab">
                    <input class="button1 orange wid" name="reset"type="reset" value="CLEAR FORM"/>
                    <!--<a href="#" class="button1 white wid" >CLEAR FORM</a>-->
                </div>
            </div>
            <div class="tabs-contact">
                <div class="tab">
                    <!--<a href="#" class="button1 orange wid" >SEND MESSAGE</a>-->
                    <input class="button1 white wid" name="submit"type="submit" value="SEND MESSAGE"/>
                </div>
            </div>
        </div>
            </form>
        
        
        </article>
        
        
        <article class="section-right-inside-contact">
        <div class="location"></div>
        </article>
        
        </div>
        </section>
      </div>
    </div>
<script type="text/javascript">
    
    if(($("#IhaveAccount").attr('checked'))=="checked")
        hideShowUserInfo('show');
    else
        hideShowUserInfo('hode');
    
    function hideShowUserInfo(whatToDo)
    {   
        if(whatToDo=="show")
            $('#showOrHide').show();
        else
            $('#showOrHide').hide();
    }
</script>    