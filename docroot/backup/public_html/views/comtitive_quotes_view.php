 <div id="main1">
          <section class="inside-title">
              <div class="inside-title-in"><div  id="main">
              <h1>Competitive quoutes | <?php echo $info['buss_name']?></h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> |  <?php echo anchor('home/business_details/'.$info['buss_id'],$info['buss_name']); ?> | Cmpetitive Quotes</div></div>
              </div>
          </section>
        </div>
        <div class="clear"></div>
<div id="section">
        <section id="main">
            <div class="contact-main">
        <article class="section-left-inside-contact top-mar">
      <h1>competitive quotes</h1>
      
      <div class="form1">
        <?php
            $attr = array('name' => 'frmquotes', 'id' => 'frmquotes', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open('home/competitive_quotes/'.$businessId, $attr);
            ?>
          <div class="write">
           <div >
              <label>User Name * </label>
              <input name="user_name" type="text" value="" />
           </div>
           <?php echo form_error('user_name');?>
           <div class="clear"></div>
           <div >
              <label>City* </label>
              <input name="city" type="text" value="" />
           </div>
           <?php echo form_error('city');?>
           <div class="clear"></div>
           <div >
              <label>State*</label>
              <input name="state" type="text" value="" />
           </div>
           <?php echo form_error('state');?>
           <div class="clear"></div>
            
           <div >
              <label>Phone Number*</label>
              <input name="phno" type="text" value="" />
           </div>
           <?php echo form_error('phno');?>
           <div class="clear"></div>
           <div>
              <label>Email Address*</label>
              <input name="email" type="text" value="" />
           </div>
           <?php echo form_error('email');?>
           <div class="clear"></div>
          
           
            <div>
              <label>Message for Quotes*</label>
              <textarea name="msg_quotes" cols="" rows="6" class="top-mr" onFocus="if(this.value=='Write Message for Quotes')this.value=''" onBlur="if(this.value=='')this.value='Write Message for Quotes'">Write Message for Quotes</textarea>
            </div>
            <?php echo form_error('msg_quotes');?>
            <div class="clear"></div>
           <div>
            <input type="submit" id="submitquotes" value="" style="display:none;"/>
            <a href="#" class="button7" onclick="javascript: return $('#submitquotes').click(); return false;">Submit</a>
          </div>
          <div class="clear"></div>
         
        </form>
      </div>
    </div>
</div>
 </article>
    </div>
</section>
</div>

 