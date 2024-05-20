                                <ul>
                                    <li <?php if($_GET['ac'] == 'tuiguang'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('web/user/tuiguang'); ?>">推广链接</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_user'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('web/user/tuiguang_user'); ?>">注册用户</a>
                                    </li>
                                    <li <?php if($_GET['ac'] == 'tuiguang_recharge'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('web/user/tuiguang_recharge'); ?>">充值记录</a>
                                    </li>
                                    <?php 
                                        if(isset($user['introducer_type']) && $user['introducer_type']==1){
                                            if($_GET['ac'] == 'tuiguang_withdraw')
                                            {
                                                echo '<li class="current"><a href="'.\App::URL('web/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                            else
                                            {
                                                echo '<li ><a href="'.\App::URL('web/user/tuiguang_withdraw').'">提现记录</a></li>';
                                            }
                                        }
                                    ?>
                                    <li <?php if($_GET['ac'] == 'tuiguang_peizi'){echo ' class="current"';}?>>
                                        <a href="<?php echo \App::URL('web/user/tuiguang_peizi'); ?>">策略记录</a>
                                    </li>
                                    <?php if(!isset($user['introducer_type']) || $user['introducer_type']==0){?>
                                        <li <?php if($_GET['ac'] == 'tuiguang_fund'){echo ' class="current"';}?>>
                                            <a href="<?php echo \App::URL('web/user/tuiguang_fund'); ?>">推广收入</a>
                                        </li>
                                    <?php }?>
                                    
                                </ul>

