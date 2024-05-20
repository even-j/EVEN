<link href="/public/web/css/user.css" rel="stylesheet" type="text/css" media="screen,projection" />
<script type="text/javascript"src="/public/web/js/common_member.js"></script>
<div class="ms-c1 bg-night">
    <div class="w1000">
        <dl>
            <?php 
            if(!isset($_SESSION)){
                session_start();
            }
            $uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
            if($uid >0){
                $user = \Model\User\UserInfo::getinfo($uid);
                $user['user_name'] = substr_replace($user['mobile'], '****',3,4);
            }
            ?>
            <dt>
                <span><?php echo $user['user_name'];?></span>，欢迎回来！&nbsp&nbsp&nbsp&nbsp
                <?php if (!\Model\User\UserInfo::checkBindInfo($user['uid'])){?>
                <a href="<?php echo \App::URL('web/user/sfz') ?>">如需策略，请尽快进行实名认证！</a>
                <?php }?>
            </dt>
        </dl>
    </div>
</div>