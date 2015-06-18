<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
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
        .s-message {
    background: none repeat scroll 0 0 #E6E8B7;
    border: 1px solid #AFAB10;
    border-radius: 5px 5px 5px 5px;
    color: #000000;
    float: left;   
    padding: 10px;
    width: auto;
}
.s-message span {
    cursor: pointer;
    display: block;
    float: right;
    height: 16px;
    width: 16px;
    margin-left: 8px;
}
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
                <h1>Change Password</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/change_password">Dashboard</a> | Change Password
                </div>
            </section>
        </div>
        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                   
                    <div class="dash-form">
                       <div class="dash"><?php echo $this->load->view('success_error_message_area');?></div>
                        <?php
                        $attr = array('name' => 'frmUserPwdEdit', 'id' => 'frmUserPwdEdit', 'autocomplete' => 'off', 'method' => 'post');
                        echo form_open('dashboard/change_password', $attr);
                        ?>
                        <div class="dash-area">                           
                            <div class="dash-inner">
                                <label>Old Password *</label>
                                <input type="password" class="inp" name="curr_pwd" id="curr_pwd" value="<?php echo set_value('curr_pwd'); ?>"/>
                                <?php echo form_error('curr_pwd'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>New Password *</label>
                                <input type="password" class="inp" name="new_pwd" id="new_pwd" value="<?php echo set_value('new_pwd'); ?>"/>
                                <?php echo form_error('new_pwd'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Confirm New Password *</label>
                                <input type="password" class="inp" name="con_new_pwd" id="con_new_pwd" value="<?php echo set_value('con_new_pwd'); ?>"/>
                                <?php echo form_error('con_new_pwd'); ?>
                            </div>                                 
                            <div class="dash-inner">                               
                                <!--<input type="button" class="dash-button" value="CLEAR FORM">-->
                                <input type="submit" class="dashorange" value="submit">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>