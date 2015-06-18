<?php if (!empty($dealList)) { ?>

    <?php
    $cnt = $offset + 1;
    foreach ($dealList as $key => $val) {
        ?>
        <li class="<?php echo ($cnt%3==0 && $cnt!=0?'last':"");?>">
            <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES . 'deal_images/thumbs/' . $val['dealImage']; ?>" >
                <div class="pad-deal"><div class="deal-title"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>"><?php echo $val['dealOverview'];?></a></div> 

                    <div class="main-amc">
                      <div class="amc"><strong><?php echo $val['buss_name'];?></strong><br/>
                          <?php echo $val['buss_address'].','.$val['buss_city'].' - '.$val['buss_zip_code'];?><br/>
                          <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                      </div>


                        <div class="rates-one">
                            <div class="fls"><div class="rate">
                                    <ul class="rating nostar">
                                        <li class="one"><a href="#" title="1 Star">1</a></li>
                                        <li class="two"><a href="#" title="2 Stars">2</a></li>
                                        <li class="three"><a href="#" title="3 Stars">3</a></li>
                                        <li class="four"><a href="#" title="4 Stars">4</a></li>
                                        <li class="five"><a href="#" title="5 Stars">5</a></li>
                                    </ul>
                                </div></div>

                            <div class="rate-new"><span>$<?php echo $val['dealDiscounts']; ?></span>  $<?php echo $val['dealValue'] ?></div></div>
                    </div>
                    <div class="clear"></div></div>
            </div>
            <div class="clear"></div>
        </li>
    <?php 
    $cnt++;
    } ?>



<?php
}?>