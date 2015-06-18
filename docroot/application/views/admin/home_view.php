<!-- content -->
<div id="content"> 
  <!-- content / right -->
 
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5><?php echo $pageInfo[0]['pageHeading'];?></h5>
        <!--<div class="search">
          <form action="#" method="post">
            <div class="input">
              <input type="text" id="search" name="search" />
            </div>
            <div class="button">
              <input type="submit" name="submit" value="Search" />
            </div>
          </form>
        </div>-->
      </div>
     
  
	   <?php  if($this->session->flashdata('item') != '') { ?>
	   			 <div class="messages">
				<div id="message-success" class="message message-success">
				<div class="image">
				<?php echo  img(array('src'=>'assets/images/icons/success.png','border'=>'0','height'=>'32','alt'=>'Success')) ?>
				</div>
				<div class="text">
				<h6><span><?php echo $this->session->flashdata('item'); ?></span></h6>
				</div>
				<div class="dismiss"><script>$('#message-success').fadeOut(5000);</script><a href="#message-success"></a></div>
				</div>
				 </div>
		 <?php } ?>					
      <div class="table">
        <?php echo $pageInfo[0]['pageContent'];?>
      </div>
    </div>
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
