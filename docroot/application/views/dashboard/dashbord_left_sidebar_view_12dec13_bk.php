<aside class="q-links"><h1>Quick Links</h1>
                    <ul>
                        <?php if($this->session->userdata('user_type') == 'buss_user'){ ?>
                        <li><?php echo anchor('dashboard/business_overview', 'Business List', 'title="Business List"');?></li>                        
                            <?php }?>                       
                        <li><?php echo anchor('dashboard/account_overview', 'Account', 'title="Account"');?></li>
                        <li><a href="#">Gift Cards</a></li>
                        <?php if($this->session->userdata('user_type') == 'buss_user'){ ?>
                        <li><?php echo anchor('dashboard/manage_subscription', 'Subscription', 'title="Subscription"');?></li>                      
                            <?php }?>
                        <li><?php echo anchor('dashboard/deals', 'Deals & Coupons', 'title="Deals & Coupons"');?></li>
                        <li><?php echo anchor('dashboard/jobs', 'Jobs', 'title="Jobs"');?></li>
                        <li><?php echo anchor('dashboard/reviews', 'Business Reviews', 'title="Business Reviews"');?></li>
                        <li><a href="#">Favorite</a></li>
                        <li><?php echo anchor('dashboard/badges', 'Badges', 'title="Badges"');?></li>
                        <li><?php echo anchor('dashboard/referral', 'Referral', 'title="Referral"');?></li>
                        <li><?php echo anchor('dashboard/change_password', 'Change Password', 'title="Change Password"');?></li>
                    </ul>
                </aside>
