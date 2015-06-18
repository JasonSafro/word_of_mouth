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
    .t-top1 {
    background: none repeat scroll 0 0 #F9F9F9;
    border-bottom: 1px solid #D0D0D0;
    border-right: 1px solid #D0D0D0;    
    border-left: 1px solid #D0D0D0;
    color: #00537C;
    font-family: 'RobotoBlack';
    font-size: 15px;
    font-weight: normal;
    line-height: 27px;
    padding: 0 10px;    
    text-align: left;   
}
.t-top1:last-child {
    border-right: medium;
}
a{color: #00537C;}
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/business_overview">Dashboard</a> | Badges
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                  
                    <div class="dash-form">
                        <table width="100%">                            
                            <tr>
                                <th class="t-top1" style="height: 30px;"><H1><strong>Reviewer</strong></H1></th>
                                <th class="t-top1" style="height: 30px;"><H1><strong>Referral</strong></H1></th>
                            </tr>
                            <tr>
                                <td class="t-top1">Reputed Reviewer <?php  if($reviewsCount>=10){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                                <td class="t-top1">WOM’s Favorite <?php  if($referralCount>=5){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                            </tr>
                            <tr>
                                <td class="t-top1">Expert Reviewer <?php  if($reviewsCount>=50){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                                <td class="t-top1">WOM’s Pal <?php  if($referralCount>=10){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                            </tr>
                            <tr>
                                <td class="t-top1">Critique <?php  if($reviewsCount>=75){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                                <td class="t-top1">WOM’s BFF <?php  if($referralCount>=20){ echo img(array('src'=>USER_SIDE_IMAGES.'tick.png')); } ?></td>
                            </tr>
                            <tr>
                                <td class="t-top1">Subject matter expert
                                <?php if(!empty($expertReviewersResult)){
                                    $count=1;
                                    foreach($expertReviewersResult as $key=>$val){
                                        if($val['reviewsCount']>50){
                                            echo br(1);
                                            echo $count.'. '.$val['catName'].' '.img(array('src'=>USER_SIDE_IMAGES.'tick.png'));
                                        }
                                    }
                                }
?>
                                </td>
                                <td class="t-top1"></td>
                            </tr>
                        </table>
                    </div>
                </div>




            </section></div>






    </div>
</div>