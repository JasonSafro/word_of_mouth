<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.selectbox-0.2.js"); ?>
<script type="text/javascript">
    $(function () {
      //  $("#userCountry").selectbox();
       // $("#userState").selectbox();
    });
</script>
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
                <h1>Response</h1>
                
            </section></div>


        <div class="dash"><section id="main" style="height:300px;">
                <?php echo $this->load->view('success_error_message_area');?>
                <div class="dash-r">                   
                    
                </div>
            </section></div>
    </div>
</div>