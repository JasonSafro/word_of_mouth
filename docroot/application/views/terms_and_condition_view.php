  <script type="text/javascript">
// Popup window code

function closeWin(){
    self.close ()
    
}
</script>
<div id="page-wrap">
        <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in"><div  id="main">
          <h1>Terms & Conditions</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>services">Our services</a> | Terms and Conditions</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div> 
      <div id="section">
        <section id="main">
            <div class="about-main">                
        <?php  echo $pageInfo[0]['pageContent'];?>
        </div>
        
            <div class="clear"></div>
            <input type="button" value="Back" onclick="javascript: self.close ();"/>
        </section>
      </div>
</div>