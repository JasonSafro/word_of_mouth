<style>
    .s-message {
    background: none repeat scroll 0 0 #E6E8B7;
    border: 1px solid #AFAB10;
    border-radius: 5px 5px 5px 5px;
    color: #000000;
    float: left;
    margin: 0 78px;
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
</style>
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
              <h1>Advance Search</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> |  <?php echo anchor('home/dashboard','Dashboard'); ?> | Advance search</div></div>
              </div>
          </section>
        </div>
        <div class="clear"></div>
 
      <div id="section">
        <section id="main">
            <div class="contact-main">
        <article class="section-left-inside-contact top-mar">
            <div class="dash"><?php echo $this->load->view('success_error_message_area');?></div>
            <h3>Advance search</h3>
        <div class="clear"></div>
         <?php 
        $attr = array('name' => 'frmAdvanceSearch', 'id' => 'frmAdvanceSearch', 'autocomplete' => 'off', 'method' => 'post');        
        echo form_open_multipart('advance_search/do_search', $attr);
        ?>
        
        <label>Zip Code</label><input name="zipCode" type="text" value="<?php echo set_value('zipCode',$zipCode);?>"/><?php echo form_error('zipCode');?> 
        <label>Country</label>
        <select name="country" id="c_userCountry" class="items">
                <?php 
                $countryList= _getCountryList();
                foreach($countryList as $key=>$val){?>
                    <option value="<?php echo $key;?>" onclick="changeStateList('<?php echo $key;?>');"><?php echo $val;?></option>
                <?php }
                ?>           
            </select>
        <label>State</label>
        <?php 
            $xy='id="searchState" class="items"';
            $stateArray=array('','Choose your state');// _getStateList()
            echo form_dropdown('state',$stateArray,set_value('state'),$xy);
        ?>
        
        <label>City</label><input name="city" type="text" value="<?php echo set_value('city',$city);?>"/><?php echo form_error('city');?> 
        <label>Radius</label><input name="radius" type="text" value="<?php echo set_value('radius',$radius);?>"/><?php echo form_error('radius');?> 
        
        <label>Has images?</label>
        <input type="radio" name="hasImage" id="hasImage" value="yes" style="width:auto !important;" <?php echo set_radio('hasImage','yes');?>/> Yes
        <input type="radio" name="hasImage" id="notHasImage" value="no" style="width:auto !important;" <?php echo set_radio('hasImage','no');?>/> No
        <div class="clear"></div>    
        
        <label>Has video?</label>
        <input type="radio" name="hasVideo" id="hasVideo" value="yes" style="width:auto !important;" <?php echo set_radio('hasVideo','yes');?>/> Yes
        <input type="radio" name="hasVideo" id="notHasVideo" value="no" style="width:auto !important;" <?php echo set_radio('hasVideo','no');?>/> No
        <div class="clear"></div>    
        
        <label>Has additional info?</label>
        <input type="radio" name="hasAdditionalInfo" id="hasAdditionalInfo" value="yes" style="width:auto !important;" <?php echo set_radio('hasAdditionalInfo','yes');?>/> Yes
        <input type="radio" name="hasAdditionalInfo" id="notFasAdditionalInfo" value="no" style="width:auto !important;"  <?php echo set_radio('hasAdditionalInfo','no');?>/> No
        <div class="clear"></div>    
        
        <label>Has offers?</label>
        <input type="radio" name="hasOffers" id="hasOffers" value="yes" style="width:auto !important;" <?php echo set_radio('hasOffers','yes');?>/> Yes
        <input type="radio" name="hasOffers" id="notHasOffers" value="no" style="width:auto !important;"  <?php echo set_radio('hasOffers','no');?>/> No
        <div class="clear"></div>
        
        <label>Minimum Rating</label>
        <?php 
            $xy='id="minRating" class="items"';
            $ratingArray=array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');// _getStateList()
            echo form_dropdown('minRating',$ratingArray,set_value('minRating',$minRating),$xy);
        ?>
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
                    <input class="button1 white wid" name="submit"type="submit" value="Search"/>
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
<script>
    function changeStateList(countryCode)
    {
        $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>services/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById('searchState');
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;                               
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                });
                                //$('#p_userState').parent().children(':not(#p_userState)').remove();
                                //$('#p_userState').selectbox();
                    }
            });
    }
</script>    