<?php

return '{
    "button": [ 
        {
            "type": "view",
            "name": "免费彩券",
            "url": "'.DOMAIN.'/index.php?app=wap&mod=hongbao&ac=huodong_index"
        },
        {
            "type": "view",
            "name": "买彩票",
            "url": "'.DOMAIN.'/index.php"
        },
        {
            "name": "帐户中心",
            "sub_button": [
                {
                    "type": "view",
                    "name": "帐户中心",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=user&ac=account"
                },
                {
                    "type": "view",
                    "name": "投注记录",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=my"
                },
                {
                    "type": "view",
                    "name": "我的彩券",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=user&ac=hongbao"
                },
                {
                    "type": "view",
                    "name": "帮助说明",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=help&ac=useraccounthelp"
                },
                {
                    "type": "view",
                    "name": "开奖公告",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=gonggao"
                }
            ]
        }
    ]
}';
