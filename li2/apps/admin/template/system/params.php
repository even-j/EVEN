<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
         <!--include file "admin_nav.php"-->
        <div class="result-wrap">
        	<?php if($navList){?>
        	<div class="toolbar-wrap mb10 pl10 nav_bg">
	            <div class="toolbar-item">
	                <i class="icon-font"></i> 
	                <?php foreach ($navList as $nav){?>
	                <a href="/index.php?app=admin&mod=system&ac=params&type=<?php echo $nav['id'];?>" <?php if($type!=$nav['id']){?>class="gray9"<?php }?>><?php echo $nav['name'];?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
	                <?php }?>
	            </div>
	        </div>
        	<?php }?>
        	<?php if($type==1){?>
            <form action="/index.php?app=admin&mod=system&ac=doPeizi" method="post" id="myform" name="myform" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>策略参数设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>策略比例：</th>
                                    <td>
                                        <input type="text" name="pz_ratio1" id="pz_ratio1" value="<?php echo $peizi['pz_ratio1']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio2" id="pz_ratio2" value="<?php echo $peizi['pz_ratio2']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio3" id="pz_ratio3" value="<?php echo $peizi['pz_ratio3']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio4" id="pz_ratio4" value="<?php echo $peizi['pz_ratio4']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio5" id="pz_ratio5" value="<?php echo $peizi['pz_ratio5']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio6" id="pz_ratio6" value="<?php echo $peizi['pz_ratio6']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio7" id="pz_ratio7" value="<?php echo $peizi['pz_ratio7']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio8" id="pz_ratio8" value="<?php echo $peizi['pz_ratio8']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio9" id="pz_ratio9" value="<?php echo $peizi['pz_ratio9']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio10" id="pz_ratio10" value="<?php echo $peizi['pz_ratio10']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <i class="tip left pd10">（单位：倍数）</i>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损警戒线比例：</th>
                                    <td>
                                        <input type="text" name="alarm_rate1" id="alarm_rate1" value="<?php echo $peizi['alarm_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate2" id="alarm_rate2" value="<?php echo $peizi['alarm_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate3" id="alarm_rate3" value="<?php echo $peizi['alarm_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate4" id="alarm_rate4" value="<?php echo $peizi['alarm_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate5" id="alarm_rate5" value="<?php echo $peizi['alarm_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate6" id="alarm_rate6" value="<?php echo $peizi['alarm_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate7" id="alarm_rate7" value="<?php echo $peizi['alarm_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate8" id="alarm_rate8" value="<?php echo $peizi['alarm_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate9" id="alarm_rate9" value="<?php echo $peizi['alarm_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate10" id="alarm_rate10" value="<?php echo $peizi['alarm_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（保证金的百分比）</i>
                                    </td>
                                </tr>
	                            
                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损止损线比例：</th>
                                    <td>
                                        <input type="text" name="stop_rate1" id="stop_rate1" value="<?php echo $peizi['stop_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate2" id="stop_rate2" value="<?php echo $peizi['stop_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate3" id="stop_rate3" value="<?php echo $peizi['stop_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate4" id="stop_rate4" value="<?php echo $peizi['stop_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate5" id="stop_rate5" value="<?php echo $peizi['stop_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate6" id="stop_rate6" value="<?php echo $peizi['stop_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate7" id="stop_rate7" value="<?php echo $peizi['stop_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate8" id="stop_rate8" value="<?php echo $peizi['stop_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate9" id="stop_rate9" value="<?php echo $peizi['stop_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate10" id="stop_rate10" value="<?php echo $peizi['stop_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（保证金的百分比）</i>
                                    </td>
                                </tr>
                                 
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>帐户管理费：</th>
                                    <td>
                                        <input type="text" name="manage_cost_money1" id="manage_cost_money1" value="<?php echo number_format($peizi['manage_cost_money1'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money2" id="manage_cost_money2" value="<?php echo number_format($peizi['manage_cost_money2'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money3" id="manage_cost_money3" value="<?php echo number_format($peizi['manage_cost_money3'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money4" id="manage_cost_money4" value="<?php echo number_format($peizi['manage_cost_money4'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money5" id="manage_cost_money5" value="<?php echo number_format($peizi['manage_cost_money5'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money6" id="manage_cost_money6" value="<?php echo number_format($peizi['manage_cost_money6'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money7" id="manage_cost_money7" value="<?php echo number_format($peizi['manage_cost_money7'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money8" id="manage_cost_money8" value="<?php echo number_format($peizi['manage_cost_money8'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money9" id="manage_cost_money9" value="<?php echo number_format($peizi['manage_cost_money9'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money10" id="manage_cost_money10" value="<?php echo number_format($peizi['manage_cost_money10'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（单位：百分比/天）</i></td>
                                </tr>

                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>最低额度：</th>
                                    <td><input type="text" name="minLimitMoney" id="minLimitMoney" value="<?php echo $peizi['minLimitMoney']/100?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>最大额度：</th>
                                    <td><input type="text" name="maxLimitMoney" id="maxLimitMoney" value="<?php echo $peizi['maxLimitMoney']/100?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
<!--                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>最大配资比例：</th>
                                    <td><input type="text" name="maxLimitRatio" id="maxLimitRatio" value="<?php echo $peizi['maxLimitRatio']?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：倍）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>最大配资期限：</th>
                                    <td><input type="text" name="maxLimitTimes" id="maxLimitTimes" value="<?php echo $peizi['maxLimitTimes']?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：天)</i></td>
                                </tr>-->
	                            
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
               </form>
			  <?php }?>
				
			<?php if($type==2){?>
               <form action="/index.php?app=admin&mod=system&ac=doP2P" method="post" id="myform2" name="myform2" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>P2P参数设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tr>
                                <th width="15%"><i class="require-red">*</i>最搞策略额度：</th>
                                <td><input type="text" name="peizi_max" id="service_cost_rate" value="<?php echo $p2p['peizi_max']?>" onkeyup="" size="50"  class="common-text"> 
                                <i class="tip left pd10">（单位：万）</i></td>
                            </tr>
                            <tr>
                                <th width="15%">倍数</th>
                                <td>
                                    <input type="text" name="ratio1" id="service_cost_rate" value="1" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio2" id="service_cost_rate" value="2" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio3" id="service_cost_rate" value="3" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio4" id="service_cost_rate" value="4" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio5" id="service_cost_rate" value="5" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio6" id="service_cost_rate" value="6" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio7" id="service_cost_rate" value="7" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio8" id="service_cost_rate" value="8" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio9" id="service_cost_rate" value="9" style="width:40px"  class="common-text">
                                    <input type="text" name="ratio10" id="service_cost_rate" value="10" style="width:40px"  class="common-text">
                                </td>
                            </tr>
                            <tr>
                                <th width="15%"><i class="require-red">*</i>服务费率：</th>
                                <td>
                                    <input type="text" name="service_cost_rate1" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate1']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate2" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate2']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate3" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate3']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate4" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate4']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate5" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate5']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate6" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate6']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate7" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate7']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate8" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate8']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate9" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate9']?>" style="width:40px"  class="common-text">
                                    <input type="text" name="service_cost_rate10" id="service_cost_rate" value="<?php echo $p2p['service_cost_rate10']?>" style="width:40px"  class="common-text">
                                <i class="tip left pd10">（单位：百分比/月）</i></td>
                            </tr>
                            <tr>
                                <th width="15%"><i class="require-red">*</i>亏损警戒线比例：</th>
                                <td>
                                    <input type="text" name="alarm_rate1" id="alarm_rate" value="<?php echo $p2p['alarm_rate1']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate2" id="alarm_rate" value="<?php echo $p2p['alarm_rate2']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate3" id="alarm_rate" value="<?php echo $p2p['alarm_rate3']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate4" id="alarm_rate" value="<?php echo $p2p['alarm_rate4']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate5" id="alarm_rate" value="<?php echo $p2p['alarm_rate5']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate6" id="alarm_rate" value="<?php echo $p2p['alarm_rate6']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate7" id="alarm_rate" value="<?php echo $p2p['alarm_rate7']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate8" id="alarm_rate" value="<?php echo $p2p['alarm_rate8']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate9" id="alarm_rate" value="<?php echo $p2p['alarm_rate9']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <input type="text" name="alarm_rate10" id="alarm_rate" value="<?php echo $p2p['alarm_rate10']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                    <i class="tip left pd10">（单位：百分比，相对于保证金）</i>
                                </td>
                           </tr>
                           <tr>
                               <th width="15%"><i class="require-red">*</i>亏损止损线比例：</th>
                               <td>
                                   <input type="text" name="stop_rate1" id="stop_rate" value="<?php echo $p2p['stop_rate1']?>" onkeyup="" style="width:40px"  class="common-text"> 
                                   <input type="text" name="stop_rate2" id="stop_rate" value="<?php echo $p2p['stop_rate2']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate3" id="stop_rate" value="<?php echo $p2p['stop_rate3']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate4" id="stop_rate" value="<?php echo $p2p['stop_rate4']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate5" id="stop_rate" value="<?php echo $p2p['stop_rate5']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate6" id="stop_rate" value="<?php echo $p2p['stop_rate6']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate7" id="stop_rate" value="<?php echo $p2p['stop_rate7']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate8" id="stop_rate" value="<?php echo $p2p['stop_rate8']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate9" id="stop_rate" value="<?php echo $p2p['stop_rate9']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <input type="text" name="stop_rate10" id="stop_rate" value="<?php echo $p2p['stop_rate10']?>" onkeyup="" style="width:40px"  class="common-text">
                                   <i class="tip left pd10">（单位：百分比，相对于保证金)</i>
                               </td>
                           </tr>
                            <tr>
                               <th width="15%"><i class="require-red">*</i>投标有效期：</th>
                               <td><input type="text" name="limit_days" id="manage_cost_money" value="<?php echo number_format($p2p['limit_days'])?>" onkeyup="clearNoNum(this);" size="50"  class="common-text"> 
                               <i class="tip left pd10">（单位：天）</i></td>
                           </tr>
                            <tr>
                               <th width="15%"><i class="require-red">*</i>帐户管理费：</th>
                               <td><input type="text" name="manage_cost_money" id="manage_cost_money" value="<?php echo number_format($p2p['manage_cost_money']/100,2)?>" onkeyup="clearNoNum(this);" size="50"  class="common-text"> 
                               <i class="tip left pd10">（单位：元/每笔）</i></td>
                           </tr>
                            
                           
                            <tr>
                                <th></th>
                                <td>
                                    <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                    <input type="reset" value="重置" class="btn btn10 mr10">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
            <?php }?>
            
            <?php if($type==3){?>
            <form action="/index.php?app=admin&mod=system&ac=doPeiziFree" method="post" id="myform3" name="myform3" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>免费策略参数设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                                    <tr>
	                                <th width="15%"><i class="require-red">*</i>活动状态：</th>
	                                <td><input type="radio" value="1" name="status" <?php if($peizi_free['status']){?>checked="checked"<?php }?>>开启&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="status" <?php if(!$peizi_free['status']){?>checked="checked"<?php }?>>关闭 <i class="tip left pd10"></i></td>
	                            </tr>
                                    <tr>
	                                <th width="15%"><i class="require-red">*</i>每天免费体验数：</th>
	                                <td><input type="text" name="per_day_count" id="per_day_count" value="<?php echo $peizi_free['per_day_count']?>" onkeyup="" size="50"  class="common-text"> 
                                            <i class="tip left pd10">（单位：个）</i>
                                        </td>
	                            </tr>
                                    <tr>
	                                <th width="15%"><i class="require-red">*</i>免费策略金额：</th>
	                                <td><input type="text" name="service_cost_rate" id="service_cost_rate" value="<?php echo $peizi_free['service_cost_rate']?>" onkeyup="" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：元）</i></td>
	                            </tr>
	                            <tr>
	                                <th width="15%"><i class="require-red">*</i>保证金：</th>
	                                <td><input type="text" name="baozheng_free" id="baozheng_free" value="<?php echo $peizi_free['baozheng_free']?>" onkeyup="" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：元）</i></td>
	                            </tr>
	                            <tr>
	                                <th width="15%"><i class="require-red">*</i>体验天数：</th>
	                                <td><input type="text" name="free_day" id="free_day" value="<?php echo $peizi_free['free_day']?>" onkeyup="" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：天）</i></td>
	                            </tr>
	                             <tr>
	                                <th width="15%"><i class="require-red">*</i>帐户管理费：</th>
                                        <td><input type="text" name="manage_cost_money" id="manage_cost_money" value="<?php echo number_format($peizi_free['manage_cost_money']/100,2)?>" onkeyup="clearNoNum(this);" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：元/每笔）</i></td>
	                            </tr>
	                             <tr>
	                                <th width="15%"><i class="require-red">*</i>亏损警戒线比例：</th>
	                                <td><input type="text" name="alarm_rate" id="alarm_rate" value="<?php echo $peizi_free['alarm_rate']?>" onkeyup="" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：百分比，相对于策略资金）</i></td>
	                            </tr>
	                            <tr>
	                                <th width="15%"><i class="require-red">*</i>亏损止损线比例：</th>
	                                <td><input type="text" name="stop_rate" id="stop_rate" value="<?php echo $peizi_free['stop_rate']?>" onkeyup="" size="50"  class="common-text"> 
	                                <i class="tip left pd10">（单位：百分比，相对于策略资金)</i></td>
	                            </tr>
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </form>
            <?php }?>
            
            <?php if($type==4){?>
            <form action="/index.php?app=admin&mod=system&ac=doPeiziMonth" method="post" id="myform4" name="myform" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>按月策略参数设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>策略比例：</th>
                                    <td>
                                        <input type="text" name="pz_ratio1" id="pz_ratio2" value="<?php echo $peizi_month['pz_ratio1']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio2" id="pz_ratio2" value="<?php echo $peizi_month['pz_ratio2']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio3" id="pz_ratio3" value="<?php echo $peizi_month['pz_ratio3']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio4" id="pz_ratio4" value="<?php echo $peizi_month['pz_ratio4']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio5" id="pz_ratio5" value="<?php echo $peizi_month['pz_ratio5']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio6" id="pz_ratio6" value="<?php echo $peizi_month['pz_ratio6']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio7" id="pz_ratio7" value="<?php echo $peizi_month['pz_ratio7']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio8" id="pz_ratio8" value="<?php echo $peizi_month['pz_ratio8']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio9" id="pz_ratio9" value="<?php echo $peizi_month['pz_ratio9']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio10" id="pz_ratio10" value="<?php echo $peizi_month['pz_ratio10']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <i class="tip left pd10">（单位：倍数）</i>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损警戒线比例：</th>
                                    <td>
                                        <input type="text" name="alarm_rate1" id="alarm_rate2" value="<?php echo $peizi_month['alarm_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate2" id="alarm_rate2" value="<?php echo $peizi_month['alarm_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate3" id="alarm_rate3" value="<?php echo $peizi_month['alarm_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate4" id="alarm_rate4" value="<?php echo $peizi_month['alarm_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate5" id="alarm_rate5" value="<?php echo $peizi_month['alarm_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate6" id="alarm_rate6" value="<?php echo $peizi_month['alarm_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate7" id="alarm_rate7" value="<?php echo $peizi_month['alarm_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate8" id="alarm_rate8" value="<?php echo $peizi_month['alarm_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate9" id="alarm_rate9" value="<?php echo $peizi_month['alarm_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate10" id="alarm_rate10" value="<?php echo $peizi_month['alarm_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（保证金的百分比）</i>
                                    </td>
                                </tr>
	                            
                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损止损线比例：</th>
                                    <td>
                                        <input type="text" name="stop_rate1" id="stop_rate2" value="<?php echo $peizi_month['stop_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate2" id="stop_rate2" value="<?php echo $peizi_month['stop_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate3" id="stop_rate3" value="<?php echo $peizi_month['stop_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate4" id="stop_rate4" value="<?php echo $peizi_month['stop_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate5" id="stop_rate5" value="<?php echo $peizi_month['stop_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate6" id="stop_rate6" value="<?php echo $peizi_month['stop_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate7" id="stop_rate7" value="<?php echo $peizi_month['stop_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate8" id="stop_rate8" value="<?php echo $peizi_month['stop_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate9" id="stop_rate9" value="<?php echo $peizi_month['stop_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate10" id="stop_rate10" value="<?php echo $peizi_month['stop_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（保证金的百分比）</i>
                                    </td>
                                </tr>
                                 
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>月息：</th>
                                    <td>
                                        <input type="text" name="manage_cost_money1" id="manage_cost_money1" value="<?php echo number_format($peizi_month['manage_cost_money1'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money2" id="manage_cost_money2" value="<?php echo number_format($peizi_month['manage_cost_money2'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money3" id="manage_cost_money3" value="<?php echo number_format($peizi_month['manage_cost_money3'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money4" id="manage_cost_money4" value="<?php echo number_format($peizi_month['manage_cost_money4'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money5" id="manage_cost_money5" value="<?php echo number_format($peizi_month['manage_cost_money5'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money6" id="manage_cost_money6" value="<?php echo number_format($peizi_month['manage_cost_money6'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money7" id="manage_cost_money7" value="<?php echo number_format($peizi_month['manage_cost_money7'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money8" id="manage_cost_money8" value="<?php echo number_format($peizi_month['manage_cost_money8'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money9" id="manage_cost_money9" value="<?php echo number_format($peizi_month['manage_cost_money9'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money10" id="manage_cost_money10" value="<?php echo number_format($peizi_month['manage_cost_money10'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（单位：%）</i></td>
                                </tr>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>最低额度：</th>
                                    <td><input type="text" name="minLimitMoney" id="minLimitMoney" value="<?php echo $peizi_month['minLimitMoney']/100?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>最大额度：</th>
                                    <td><input type="text" name="maxLimitMoney" id="maxLimitMoney" value="<?php echo $peizi_month['maxLimitMoney']/100?>" onkeyup="" size="50"  class="common-text"> 
                                    <i class="tip left pd10">（单位：元）</i></td>
                                </tr>
	                            
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
               </form>
               <?php }?>
               
               <?php if($type==5){?>
               <form action="/index.php?app=admin&mod=system&ac=doPeiziQihuo" method="post" id="myform4" name="myform" enctype="multipart/form-data">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>期货策略参数设置</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>策略比例：</th>
                                    <td>
                                        <input type="text" name="pz_ratio1" id="pz_ratio2" value="<?php echo $peizi_qihuo['pz_ratio1']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio2" id="pz_ratio2" value="<?php echo $peizi_qihuo['pz_ratio2']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio3" id="pz_ratio3" value="<?php echo $peizi_qihuo['pz_ratio3']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio4" id="pz_ratio4" value="<?php echo $peizi_qihuo['pz_ratio4']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio5" id="pz_ratio5" value="<?php echo $peizi_qihuo['pz_ratio5']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio6" id="pz_ratio6" value="<?php echo $peizi_qihuo['pz_ratio6']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio7" id="pz_ratio7" value="<?php echo $peizi_qihuo['pz_ratio7']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio8" id="pz_ratio8" value="<?php echo $peizi_qihuo['pz_ratio8']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio9" id="pz_ratio9" value="<?php echo $peizi_qihuo['pz_ratio9']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <input type="text" name="pz_ratio10" id="pz_ratio10" value="<?php echo $peizi_qihuo['pz_ratio10']?>" onkeyup="" style="width:50px"  class="common-text" />
                                        <i class="tip left pd10">（单位：倍数）</i>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损警戒线比例：</th>
                                    <td>
                                        <input type="text" name="alarm_rate1" id="alarm_rate2" value="<?php echo $peizi_qihuo['alarm_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate2" id="alarm_rate2" value="<?php echo $peizi_qihuo['alarm_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate3" id="alarm_rate3" value="<?php echo $peizi_qihuo['alarm_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate4" id="alarm_rate4" value="<?php echo $peizi_qihuo['alarm_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate5" id="alarm_rate5" value="<?php echo $peizi_qihuo['alarm_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate6" id="alarm_rate6" value="<?php echo $peizi_qihuo['alarm_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate7" id="alarm_rate7" value="<?php echo $peizi_qihuo['alarm_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate8" id="alarm_rate8" value="<?php echo $peizi_qihuo['alarm_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate9" id="alarm_rate9" value="<?php echo $peizi_qihuo['alarm_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="alarm_rate10" id="alarm_rate10" value="<?php echo $peizi_qihuo['alarm_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（单位：百分比，相对于保证金）</i>
                                    </td>
                                </tr>
	                            
                                 <tr>
                                    <th width="15%"><i class="require-red">*</i>亏损止损线比例：</th>
                                    <td>
                                        <input type="text" name="stop_rate1" id="stop_rate2" value="<?php echo $peizi_qihuo['stop_rate1']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate2" id="stop_rate2" value="<?php echo $peizi_qihuo['stop_rate2']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate3" id="stop_rate3" value="<?php echo $peizi_qihuo['stop_rate3']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate4" id="stop_rate4" value="<?php echo $peizi_qihuo['stop_rate4']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate5" id="stop_rate5" value="<?php echo $peizi_qihuo['stop_rate5']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate6" id="stop_rate6" value="<?php echo $peizi_qihuo['stop_rate6']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate7" id="stop_rate7" value="<?php echo $peizi_qihuo['stop_rate7']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate8" id="stop_rate8" value="<?php echo $peizi_qihuo['stop_rate8']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate9" id="stop_rate9" value="<?php echo $peizi_qihuo['stop_rate9']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="stop_rate10" id="stop_rate10" value="<?php echo $peizi_qihuo['stop_rate10']?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（单位：百分比，相对于保证金）</i>
                                    </td>
                                </tr>
                                 
                                <tr>
                                    <th width="15%"><i class="require-red">*</i>月息：</th>
                                    <td>
                                        <input type="text" name="manage_cost_money1" id="manage_cost_money1" value="<?php echo number_format($peizi_qihuo['manage_cost_money1'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money2" id="manage_cost_money2" value="<?php echo number_format($peizi_qihuo['manage_cost_money2'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money3" id="manage_cost_money3" value="<?php echo number_format($peizi_qihuo['manage_cost_money3'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money4" id="manage_cost_money4" value="<?php echo number_format($peizi_qihuo['manage_cost_money4'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money5" id="manage_cost_money5" value="<?php echo number_format($peizi_qihuo['manage_cost_money5'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money6" id="manage_cost_money6" value="<?php echo number_format($peizi_qihuo['manage_cost_money6'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money7" id="manage_cost_money7" value="<?php echo number_format($peizi_qihuo['manage_cost_money7'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money8" id="manage_cost_money8" value="<?php echo number_format($peizi_qihuo['manage_cost_money8'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money9" id="manage_cost_money9" value="<?php echo number_format($peizi_qihuo['manage_cost_money9'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <input type="text" name="manage_cost_money10" id="manage_cost_money10" value="<?php echo number_format($peizi_qihuo['manage_cost_money10'],2)?>" onkeyup="" style="width:50px"  class="common-text">
                                        <i class="tip left pd10">（单位：%）</i></td>
                                </tr>

	                            
                                <tr>
                                    <th></th>
                                    <td>
                                        <input type="submit" value="提交" class="btn btn-primary btn10 mr10">
                                        <input type="reset" value="重置" class="btn btn10 mr10">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
               </form>
               <?php }?>
        </div>
    </div>
    <!--/main-->
</div>
<script language="JavaScript" type="text/javascript">
function clearNoNum(obj){   
	obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符  
 	obj.value = obj.value.replace(/^\./g,"");  //验证第一个字符是数字而不是. 
  	obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的.   
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}
</script>
<!--include file "admin_bottom.php"-->