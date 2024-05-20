<?php

return '{
    "button": [ 
        {
            "name": "粉丝福利",
            "sub_button": [
                {
                    "type": "view",
                    "name": "疯狂赚彩券",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=hongbao&ac=index"
                },
                {
                    "type": "view",
                    "name": "我的彩券",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=user&ac=hongbao"
                }
            ]
        },
        {
            "name": "买彩票",
            "sub_button": [
                {
                    "type": "view",
                    "name": "购彩大厅",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=index&ac=view"
                },
                {
                    "type": "view",
                    "name": "双色球",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=ticket&ac=view&type=ssq"
                },
                {
                    "type": "view",
                    "name": "大乐透",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=ticket&ac=view&type=dlt"
                },
                {
                    "type": "view",
                    "name": "投注记录",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=my"
                },
                {
                    "type": "view",
                    "name": "开奖公告",
                    "url": "'.DOMAIN.'/index.php?app=wap&mod=gonggao"
                }
            ]
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
                }
            ]
        }
    ]
}';
