<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($title)) echo $title.'_'?><?php echo SITE_NAME;?>—后台管理</title>
<link rel="stylesheet" type="text/css" href="/public/admin/css/common.css?v=201812202"/>
<link rel="stylesheet" type="text/css" href="/public/admin/css/main.css?v=5"/>
<script type="text/javascript" src="/public/admin/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/public/admin/js/common.js?v=201812202"></script>
<script type="text/javascript" src="/public/admin/js/libs/modernizr.min.js"></script>
<script type="text/javascript" src="/public/admin/js/layer/layer.js"></script>

</head>

<body>
<?php $admin_user = \Model\Admin\User::getAdminInfo(array('admin_id'=>\Model\Admin\User::checks())); ?>
<div class="container clearfix">
 
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span><b class="orange"><?php echo $admin_user['real_name'];?></b>，欢迎您登陆【<?php echo SITE_NAME;?>】后台管理中心。</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>快捷操作</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                	<a href="/index.php?app=admin&mod=index&ac=view" target="_top"><i class="icon-font">&#xe005;</i>综合总览</a>
                    <a href="/index.php?app=admin&mod=user&ac=view"><i class="icon-font">&#xe003;</i>用户管理</a>
                    <a href="/index.php?app=admin&mod=finance&ac=tixian"><i class="icon-font">&#xe02f;</i>提现管理</a>
                    <a href="/index.php?app=admin&mod=finance&ac=recharge"><i class="icon-font">&#xe050;</i>充值管理</a>
 
                    <br/>
                    <div style="display:none">
                        <a href="#"><i class="icon-font">&#xe001;</i>1</a>
                        <a href="#"><i class="icon-font">&#xe002;</i>2</a>
                        <a href="#"><i class="icon-font">&#xe003;</i>3</a>
                        <a href="#"><i class="icon-font">&#xe004;</i>4</a>
                        <a href="#"><i class="icon-font">&#xe005;</i>5</a>
                        <a href="#"><i class="icon-font">&#xe006;</i>6</a>
                        <a href="#"><i class="icon-font">&#xe007;</i>7</a>
                        <a href="#"><i class="icon-font">&#xe008;</i>8</a>
                        <a href="#"><i class="icon-font">&#xe009;</i>9</a>
                        <a href="#"><i class="icon-font">&#xe010;</i>10</a>
                        <a href="#"><i class="icon-font">&#xe011;</i>11</a>
                        <a href="#"><i class="icon-font">&#xe012;</i>12</a>
                        <a href="#"><i class="icon-font">&#xe013;</i>13</a>
                        <a href="#"><i class="icon-font">&#xe014;</i>14</a>
                        <a href="#"><i class="icon-font">&#xe015;</i>15</a>
                        <a href="#"><i class="icon-font">&#xe016;</i>16</a>
                        <a href="#"><i class="icon-font">&#xe017;</i>17</a>
                        <a href="#"><i class="icon-font">&#xe018;</i>18</a>
                        <a href="#"><i class="icon-font">&#xe019;</i>19</a>
                        <a href="#"><i class="icon-font">&#xe020;</i>20</a><br/>
                        <a href="#"><i class="icon-font">&#xe021;</i>21</a>
                        <a href="#"><i class="icon-font">&#xe022;</i>22</a>
                        <a href="#"><i class="icon-font">&#xe023;</i>23</a>
                        <a href="#"><i class="icon-font">&#xe024;</i>24</a>
                        <a href="#"><i class="icon-font">&#xe025;</i>25</a>
                        <a href="#"><i class="icon-font">&#xe026;</i>26</a>
                        <a href="#"><i class="icon-font">&#xe027;</i>27</a>
                        <a href="#"><i class="icon-font">&#xe028;</i>28</a>
                        <a href="#"><i class="icon-font">&#xe029;</i>29</a>
                        <a href="#"><i class="icon-font">&#xe030;</i>30</a>

                        <a href="#"><i class="icon-font">&#xe031;</i>31</a>
                        <a href="#"><i class="icon-font">&#xe032;</i>32</a>
                        <a href="#"><i class="icon-font">&#xe033;</i>33</a>
                        <a href="#"><i class="icon-font">&#xe034;</i>34</a>
                        <a href="#"><i class="icon-font">&#xe035;</i>35</a>
                        <a href="#"><i class="icon-font">&#xe036;</i>36</a>
                        <a href="#"><i class="icon-font">&#xe037;</i>37</a>
                        <a href="#"><i class="icon-font">&#xe038;</i>38</a>
                        <a href="#"><i class="icon-font">&#xe039;</i>39</a><br/>
                        <a href="#"><i class="icon-font">&#xe040;</i>40</a>
                         <a href="#"><i class="icon-font">&#xe041;</i>41</a>
                        <a href="#"><i class="icon-font">&#xe042;</i>42</a>
                        <a href="#"><i class="icon-font">&#xe043;</i>43</a>
                        <a href="#"><i class="icon-font">&#xe044;</i>44</a>
                        <a href="#"><i class="icon-font">&#xe045;</i>45</a>
                        <a href="#"><i class="icon-font">&#xe046;</i>46</a>
                        <a href="#"><i class="icon-font">&#xe047;</i>47</a>
                        <a href="#"><i class="icon-font">&#xe048;</i>48</a>
                        <a href="#"><i class="icon-font">&#xe049;</i>49</a>
                        <a href="#"><i class="icon-font">&#xe050;</i>50</a>
                         <a href="#"><i class="icon-font">&#xe051;</i>51</a>
                        <a href="#"><i class="icon-font">&#xe052;</i>52</a>
                        <a href="#"><i class="icon-font">&#xe053;</i>53</a>
                        <a href="#"><i class="icon-font">&#xe054;</i>54</a>
                        <a href="#"><i class="icon-font">&#xe055;</i>55</a>
                        <a href="#"><i class="icon-font">&#xe056;</i>56</a>
                        <a href="#"><i class="icon-font">&#xe057;</i>57</a>
                        <a href="#"><i class="icon-font">&#xe058;</i>58</a><br/>
                        <a href="#"><i class="icon-font">&#xe059;</i>59</a>
                        <a href="#"><i class="icon-font">&#xe060;</i>60</a>
                         <a href="#"><i class="icon-font">&#xe061;</i>61</a>
                        <a href="#"><i class="icon-font">&#xe062;</i>62</a>
                        <a href="#"><i class="icon-font">&#xe063;</i>63</a>
                        <a href="#"><i class="icon-font">&#xe064;</i>64</a>
                        <a href="#"><i class="icon-font">&#xe065;</i>65</a>
                        <a href="#"><i class="icon-font">&#xe066;</i>66</a>
                        <a href="#"><i class="icon-font">&#xe067;</i>67</a>
                        <a href="#"><i class="icon-font">&#xe068;</i>68</a>
                        <a href="#"><i class="icon-font">&#xe069;</i>69</a>

                        <a href="#"><i class="icon-font">&#xe01e;</i>70</a>
                        <a href="#"><i class="icon-font">&#xe02e;</i>71</a>
                        <a href="#"><i class="icon-font">&#xe03e;</i>72</a>
                        <a href="#"><i class="icon-font">&#xe04e;</i>73</a>
                        <a href="#"><i class="icon-font">&#xe05e;</i>74</a>

                        <a href="#"><i class="icon-font">&#xe01a;</i>75</a>
                        <a href="#"><i class="icon-font">&#xe02a;</i>76</a>
                        <a href="#"><i class="icon-font">&#xe03a;</i>77</a><br/>
                        <a href="#"><i class="icon-font">&#xe04a;</i>78</a>
                        <a href="#"><i class="icon-font">&#xe05a;</i>79</a>

                        <a href="#"><i class="icon-font">&#xe01b;</i>80</a>
                        <a href="#"><i class="icon-font">&#xe02b;</i>81</a>
                        <a href="#"><i class="icon-font">&#xe03b;</i>82</a>
                        <a href="#"><i class="icon-font">&#xe04b;</i>83</a>
                        <a href="#"><i class="icon-font">&#xe05b;</i>84</a>

                         <a href="#"><i class="icon-font">&#xe01c;</i>85</a>
                        <a href="#"><i class="icon-font">&#xe02c;</i>86</a>
                        <a href="#"><i class="icon-font">&#xe03c;</i>87</a>
                        <a href="#"><i class="icon-font">&#xe04c;</i>88</a>
                        <a href="#"><i class="icon-font">&#xe05c;</i>89</a>

                         <a href="#"><i class="icon-font">&#xe01d;</i>90</a>
                        <a href="#"><i class="icon-font">&#xe02d;</i>91</a>
                        <a href="#"><i class="icon-font">&#xe03d;</i>92</a>
                        <a href="#"><i class="icon-font">&#xe04d;</i>93</a>
                        <a href="#"><i class="icon-font">&#xe05d;</i>94</a>
                        
                        
                         <a href="#"><i class="icon-font">&#xe01f;</i>95</a>
                        <a href="#"><i class="icon-font">&#xe02f;</i>96</a><br/>
                        <a href="#"><i class="icon-font">&#xe03f;</i>97</a>
                        <a href="#"><i class="icon-font">&#xe04f;</i>98</a>
                        <a href="#"><i class="icon-font">&#xe05f;</i>99</a>
                        
                    </div>
                  <br/>
                    
                   
                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>待办事项</h1>
            </div>
            <div class="waitdo">
                <ul>
                    <li>策略资金划拔处理： <a onclick="openWin('实盘资金划拨','/index.php?app=admin&mod=peizi&ac=fund&status=1')" href=""><?php echo  $data['wait_peizi']>0? ('<span style="color:red">'.$data['wait_peizi'].'</span>'):$data['wait_peizi']?></a></li>
                    <li>追加策略划拔处理： <a onclick="openWin('追加实盘金划拔','/index.php?app=admin&mod=peizi&ac=plus&status=0')" href=""><?php echo $data['wait_peizi_add']>0? ('<span style="color:red">'.$data['wait_peizi_add'].'</span>'):$data['wait_peizi_add'] ?></a></li>
                    <li>补亏划拔处理： <a onclick="openWin('补亏划拨','/index.php?app=admin&mod=peizi&ac=loss&status=0')" href=""><?php echo $data['wait_fillloss']>0? ('<span style="color:red">'.$data['wait_fillloss'].'</span>'):$data['wait_fillloss'] ?></a></li>
                    <li>盈利提取处理： <a onclick="openWin('盈利提取','/index.php?app=admin&mod=system&ac=getprofit&status=0')" href=""><?php echo $data['get_profit']>0? ('<span style="color:red">'.$data['get_profit'].'</span>'):$data['get_profit'] ?></a></li>
                    <li>申请结束策略处理： <a onclick="openWin('结束配资','/index.php?app=admin&mod=peizi&ac=win&status=3')" href=""><?php echo $data['wait_userend']>0? ('<span style="color:red">'.$data['wait_userend'].'</span>'):$data['wait_userend'] ?></a></li>
                    <li>操盘普通账号剩余： <a onclick="openWin('交易账户管理','/index.php?app=admin&mod=trade&ac=view&type=1&status=0')" href=""><?php echo $data['wait_account']<10? ('<span style="color:red">'.$data['wait_account'].'</span>'):$data['wait_account'] ?></a></li>
                    <li>操盘管理费不足处理： <a onclick="openWin('管理费不足','/index.php?app=admin&mod=peizi&ac=mcost')" href=""><?php echo $data['wait_nobalance']>0? ('<span style="color:red">'.$data['wait_nobalance'].'</span>'):$data['wait_nobalance'] ?></a></li>
                    <li>银行卡待审核处理： <a onclick="openWin('用户管理','/index.php?app=admin&mod=user&ac=view&is_audit=0')" href=""><?php echo $data['wait_bankcard']>0? ('<span style="color:red">'.$data['wait_bankcard'].'</span>') : $data['wait_bankcard'] ?></a></li>
                    <!--<li>待回复的问题： <a href="/index.php?app=admin&mod=question&ac=view&status=1"><?php echo $data['wait_question']>0? ('<span style="color:red">'.$data['wait_question'].'</span>') : $data['wait_question'] ?></a></li>-->
                    <li>免费体验操盘账号剩余： <a onclick="openWin('交易账户管理','/index.php?app=admin&mod=trade&ac=view&type=2&status=0')" href=""><?php echo $data['wait_account_free']<10? ('<span style="color:red">'.$data['wait_account_free'].'</span>'):$data['wait_account_free'] ?></a></li>
                    <li>免费体验申请结束操盘： <a onclick="openWin('免费体验','/index.php?app=admin&mod=peizi&ac=free&status=3')" href=""><?php echo $data['wait_userend4']>0? ('<span style="color:red">'.$data['wait_userend4'].'</span>'):$data['wait_userend4'] ?></a></li>
                    <li>免费体验到期结束： <a onclick="openWin('免费体验','/index.php?app=admin&mod=peizi&ac=free&status=2')" href=""><?php echo $data['wait_free_end']>0? ('<span style="color:red">'.$data['wait_free_end'].'</span>'):$data['wait_free_end'] ?></a></li>
                    <li>提现处理： <a onclick="openWin('提现管理','/index.php?app=admin&mod=finance&ac=tixian&status=0')" href=""><?php echo $data['wait_withdraw']>0? ('<span style="color:red">'.$data['wait_withdraw'].'</span>'):$data['wait_withdraw'] ?></a></li>
                    <li>线下充值待处理： <a onclick="openWin('线下充值管理','/index.php?app=admin&mod=finance&ac=rechargeoffline&status=0')" href=""><?php echo $data['recharge_offline']>0? ('<span style="color:red">'.$data['recharge_offline'].'</span>'):$data['recharge_offline'] ?></a></li>
                    
                </ul>
            </div>
            <div class="result-title mt10">
                <h1>综合预览</h1>
            </div>
            <div class="result-content">
            	  <ul class="sys-info-list mb20">
                    <li>
                        <label class="res-lab">总用户数：</label><span class="res-info"><?php echo $data['total'];?></span>
                    </li>
                    <li>
                        <label class="res-lab">策略用户数：</label><span class="res-info"><a href="/index.php?app=admin&mod=user&ac=view&status=1"><?php echo $data['pz_user'];?></a></span>
                        <label class="res-lab">策略用户占总用户数：</label><span class="res-info"><?php echo $data['pz_user_per'];?></span>
                    </li>
                    
                     <li>
                     	<label class="res-lab">免费体验用户数：</label><span class="res-info"><a href="/index.php?app=admin&mod=user&ac=view&is_free=1"><?php echo $data['free_pz'];?></a></span>
                     	<label class="res-lab">按日策略用户数：</label><span class="res-info"><a href="/index.php?app=admin&mod=user&ac=view&is_day=1"><?php echo $data['day_pz'];?></a></span>
                        <label class="res-lab">按月策略用户数：</label><span class="res-info"><a href="/index.php?app=admin&mod=user&ac=view&is_month=1"><?php echo $data['month_pz'];?></a></span>
                     </li>
                    
               </ul>
               
                 <table class="result-tab mb20" style="width:100%">
                        <tr>
                            <th style="width:303px">昨日新增用户数</th>
                            <th style="width:303px">近7日新增用户数</th>
                            <th style="width:303px">近30日新增用户数</th>	
                        </tr>
                          <tr>
                            <td><?php echo $data['reg_yesterday'];?>个</td>
                            <td><?php echo $data['reg_week'];?>个</td>
                            <td><?php echo $data['reg_month'];?>个</td>
                        </tr>
            	 </table>     
            	 
                <table class="result-tab mb20" style="width:100%">
                        <tr>
                            <th style="width:150px">昨日登录用户数</th>
                            <th style="width:150px">占比</th>
                            <th style="width:150px">近7日登录用户数</th>
                            <th style="width:150px">占比</th>
                            <th style="width:150px">近30日登录用户数</th>
                            <th style="width:150px">占比</th>
                        </tr>
                          <tr>
                            <td><?php echo $data['login_yesterday'];?>个</td>
                            <td><?php echo $data['login_yesterday_per'];?></td>
                            <td><?php echo $data['login_week'];?>个</td>
                            <td><?php echo $data['login_week_per'];?></td>
                            <td><?php echo $data['login_month'];?>个</td>
                            <td><?php echo $data['login_month_per'];?></td>
                        </tr>
            	 </table>             
                			
            </div>
            <?php $ids = \apps\Config::getInstance()->admin_show_money_ids;?>
            <?php if(empty($ids) || in_array($adminid, $ids)){?>
            <div class="result-title mt10">
                <h1>财务数据</h1>
            </div>
            <div class="result-content">
                <table class="result-tab mb20" style="width:100%">
                        <tr>
                            <th>总充值</th>
                            <th>总提现</th>
                            <th>总管理费</th>
                            <th>总冻结资金</th>
                            <th>总余额</th>
                            <th>充值赠送</th>
                        </tr>
                          <tr>
                            <td><?php echo number_format(($data['recharge']/100),2)?></td>
                            <td><?php echo number_format(($data['tixian']/100),2)?></td>
                            <td><?php echo number_format(($data['gl_fee']/100),2)?></td>
                            <td><?php echo number_format(($data['frozen']/100),2)?></td>
                            <td><?php echo number_format(($data['balance']/100),2)?></td>
                           <td><?php echo number_format(($data['recharge_send']/100),2)?></td>
                           
                        </tr>
            	 </table>             
            	 
          </div>
            <?php }?>
        </div>
    </div>
    <!--/main-->
</div>

<script type="text/javascript">

function show(title,url){
	//iframe层
    layer.open({
        type: 2,
        title: title,
        shadeClose: true,
        shade: 0.8,
        fix: false, //不固定
        maxmin: true,
        area: ['60%', '500px'],
        content: url //iframe的url
    }); 
}
var layerIndex = 0;
var isOpen=false;
var interval= window.setInterval("showWindow()",20000);
function showWindow(){
	$.post('/index.php?app=admin&mod=index&ac=showWindow',{},function(res){
		 if(res.status=='1'){
                    if(isOpen){
                        layer.close(layerIndex);
                    }
                    //iframe窗
                    layerIndex = layer.open({
                        type: 1,
                        title: '您有新的<b class="red"> '+res.num+' </b>条待办事项',
                        shade: false,
                        //skin: 'layui-layer-demo', //样式类名
                        area: ['340px', '315px'],
                        shadeClose: false, //开启遮罩关闭
                        offset: 'rb', //右下角弹出
                        content: '<div class="result-content"><ul id="wait-do" class="sys-info-list pt10">'+res.msg+'</ul></div><div style="display:none;"><audio controls="true" autoplay="autoplay" loop="loop"><source src="/public/admin/sound/music.mp3" /><source src="/public/admin/sound/music.ogg" /></audio></div>', 
                        end:function(){ // 点击右上角关闭按钮  
                            isOpen=false;
                            layerIndex=0;
                        }
                    });
                    isOpen = true;
		 }
	},'json');
}

</script>
</body>
</html>

