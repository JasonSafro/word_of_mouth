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
          <h1>FAQ</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>faq/">Home</a> | FAQ</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>   
      <div id="section">
        <section id="main"><div class="contact-main">                
                 <article class="section-left-inside-faq top-mar"><h3>Freqently Asked Questions</h3>
                      <div class="right-line">                                        
    <?php
    $size=count($user_faq); 
    foreach($user_faq as $key=>$val)
  {?>                
   <div class="question <?php echo ($size-1==$key?"btt0m-line":"")?>"><a class="foractive" id="que_<?php echo $val['faqId'];?>" onclick="javaScript:getDescription(<?php echo $val['faqId'];?>)"><?php echo $val['faqTitle'];?></a></div> 
   <?php }?> 
     </div>
        </article>
                
                  <article class="section-right-inside-contact tm">
        <div class="faq">
       
       <h3>Response to Questions</h3>
       <div class="orange-txt" id="ret_question"></div>
       <p id="description"></p>
       <div class="clear"></div>
              </div>
        </article>
                  
  
        </div></section>
        
      </div>
        
    </div> 
<script>
    function getDescription(faqId) { 
     $.get('<?php echo site_url() ?>faq/get_description/'+faqId).done(function(response) {
                        $(".foractive").attr('class','foractive');
                        $('#que_'+faqId).attr('class','foractive active');
                        var que=$('#que_'+faqId).text();
                        $('#ret_question').empty().html(que);
                        $('#description').html(response);
                }); 
                }
    </script>