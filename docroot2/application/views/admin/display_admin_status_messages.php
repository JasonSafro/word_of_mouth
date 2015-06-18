<?php
if ($this->session->flashdata('error') != '') {
    ?>
    <div class="messages">
        <div id="message-error" class="message message-error" >
            <div class="image">
                <?php echo image_asset('icons/error.png', '', array('border' => '0', 'height' => '21', 'alt' => 'Error')); ?> 
            </div>
            <div class="text">
                <!--<h6>Error Message</h6>-->
                <span><?php echo $this->session->flashdata('error'); ?></span>
            </div>
            <div class="dismiss">
                <!--<script type="text/javascript">$('#message-error').fadeOut(6000);</script>--><a href="#message-error"></a>
            </div>
        </div>
    </div>
<?php } ?>

<?php
if ($this->session->flashdata('success') != '') {
    ?>
    <div class="messages">
        <div id="message-success" class="message message-success" >
            <div class="image">
                <?php echo image_asset('icons/success.png', '', array('border' => '0', 'height' => '21', 'alt' => 'Error')); ?> 
            </div>
            <div class="text">
                <!--<h6>Error Message</h6>-->
                <span><?php echo $this->session->flashdata('success'); ?></span>
            </div>
            <div class="dismiss">
               <!-- <script type="text/javascript">$('#message-success').fadeOut(6000);</script>--><a href="#message-success"></a>
            </div>
        </div>
    </div>
<?php } ?>

<?php
if ($this->session->userdata('session_error') != '') {
    ?>
    <div class="messages">
        <div id="message-error" class="message message-error" >
            <div class="image">
                <?php echo image_asset('icons/error.png', '', array('border' => '0', 'height' => '21', 'alt' => 'Error')); ?> 
            </div>
            <div class="text">
                <!--<h6>Error Message</h6>-->
                <span><?php echo $this->session->userdata('session_error'); ?></span>
                <?php $this->session->unset_userdata('session_error');?>
            </div>
            <div class="dismiss">
                <!--<script type="text/javascript">$('#message-error').fadeOut(6000);</script>--><a href="#message-error"></a>
            </div>
        </div>
    </div>
<?php } ?>