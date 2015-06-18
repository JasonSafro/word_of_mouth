<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
  
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=='new'?"Create New newsletter":"Edit Newsletter");?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            <?php
            $attr = array('name' => 'frmaddnewsletter', 'id' => 'frmaddnewsletter', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open(ADMIN_FOLDER_NAME.'/manage_newsletter/'.($action=='new'?'add':"edit/$newsId"), $attr);
            ?>
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Subject:</label>
                            </div>
                            <div class="input">
                                <input name="newsSubject" id="newsSubject" value="<?php echo set_value('newsSubject',$newsSubject);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('newsSubject');?>
                            </div>
                     </div> 

                      <div class="field">
                            <div class="label">
                                <label for="input-large">Message:</label>
                            </div>
                            <div class="input">
                                <textarea name="newsMessageBody" id="newsMessageBody" cols="60" rows="4"><?php echo set_value('newsMessageBody',$newsMessageBody);?></textarea>                                <?php echo form_error('newsMessageBody');?>
                            </div>                            
                        </div> 
            
              <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="<?php echo ($action=='new'?"Save":"Save Changes");?>"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_newsletter";?>'" /> 							
                        </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>                     
    </div>
    <!-- end content / right -->
</div>



</body>
</html>
