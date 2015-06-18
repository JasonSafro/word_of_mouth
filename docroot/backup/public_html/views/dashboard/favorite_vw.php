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
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Favorite List
                </div>
            </section></div>
<div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                  
                    <div class="dash-form">
                        <table width="100%">
                            <tr><th COLSPAN="4" class="t-top1" style="height: 30px;"><H1><strong>Favorite Business</strong></H1></th></tr>                            
                            <tr>
                            <th class="t-top1" width="15%">Logo</th>
                            <th class="t-top1" width="45%">Business Name</th>
                            <th class="t-top1" width="30%">Created Date</th>
                            <th class="t-top1" width="10%">Action</th>
                            </tr>
                             <?php  if(count($fav_Info)!=0){//bussStatus
                                         foreach($fav_Info as $key=>$val){ 
                                         //$b_name = _Get_bussiness_name($fav['business_id']);?>    
                             <tr>
                            <td class="t-top1" align="center">
                                <?php 
                                if($val['bussStatus']=='Active')                                    
                                    echo anchor('home/business_details/'.$val['business_id'],img(array('src'=>base_url().'LOGO/'.$val['buss_logo'],'style'=>'float:left; width:109px; height:75px;')));
                                else
                                    echo img(array('src'=>base_url().'LOGO/'.$val['buss_logo'],'style'=>'float:left; width:100px; height:100px;'));?>
                            </td>
                            <td class="t-top1"><?php echo anchor('home/business_details/'.$val['business_id'], $val['buss_name'], 'title="Business Name"');?></td>
                            <td class="t-top1"> <?php echo date('Y-m-d h:i a',strtotime($val['created_date']));?></td>
                            <td class="t-top1">
                            <?php echo anchor(site_url('dashboard/favorite/delete/'.$val['buss_favorite_id']), img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
                            
                            
                          <!--  <a href="<?php // echo site_url('dashboard/favorite/delete')."/".$fav['buss_favorite_id']; ?>">Delete</a>--></td>
                            </tr>
                            
                    <?php } }else { ?>
                    <tr>
                            <td class="t-top1" width="20%" colspan="3" align="center"> No Record Found</td>
                            
                            </tr>
                            <?php }?>    
                                </table>                        
                           
                    </div>
                </div>




            </section></div>
            
            
            
       
    </div>
</div>
