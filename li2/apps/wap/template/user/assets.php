<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <!--include file "common.php"-->
        <link rel="stylesheet" href="../../public/wap/css/wap_new.css">
    </head>
    <body>
        <!--第二行-->
        <!--------头部导航------------>
        <div class="body">
            <div class="header">
                <h1>帐户资产</h1>
                <a class="l-link" href="javascript:history.go(-1)"><span>返回</span></a> 
                <div class="top-menu">
                    <!--<button type="button" class="btn"></button>-->
                </div>
            </div>
            
            <!-----------登录框开始----------------->
            <div class="m15 mt60">
                <div class="wrap-a">
                    <div class="formbox m_a_none">   
                        <table>
                            <tbody>
                                <tr class="bgc1">
                                    <th>总资产：</th>
                                    <td class="r"><strong><?php echo number_format((floatval($userinfo['balance'])+floatval($userinfo['frozen'])+floatval($userinfo['send']))/100,2) ?></strong>元</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td class="r-e">
                                        <h6>账户余额</h6>
                                        <span class="c-red"><?php echo number_format(floatval($userinfo['balance'])/100,2) ?></span>元
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td class="r-p">
                                        <h6>冻结资金</h6>
                                        <span class="c-red"><?php echo number_format(floatval($userinfo['frozen'])/100,2) ?></span>元
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td class="r-p">
                                        <h6>赠送管理费余额</h6>
                                        <span class="c-red"><?php echo number_format(floatval($userinfo['send'])/100,2) ?></span>元
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="btnbox" style="margin-top: 40px">
                        <a class="btn_primary" href = '<?php echo \App::URL('wap/user/fund')?>'>查询资金流水</a>
                    </div>
                </div>	
            </div>
        </div>
    </body>
</html>