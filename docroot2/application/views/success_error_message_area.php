<script>
function closeMessageDiv(divId)
{
    $(divId).css('display','none');
}
</script>

<?php if($this->session->flashdata('success')!=''){?>
<div class="s-message" id="greenMessage"><?php echo $this->session->flashdata('success');?> <span onclick="closeMessageDiv('#greenMessage');"></span></div>
<?php }?>

<?php if($this->session->flashdata('error')!=''){?>
<div class="s-messagerro" id="redMessage"><?php echo $this->session->flashdata('error');?><span onclick="closeMessageDiv('#redMessage');"></span></div>
<?php }?>

