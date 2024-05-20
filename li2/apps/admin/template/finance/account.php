<!--include file "admin_include.php"-->
    
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                	<input type="hidden" name="app" value="admin" >
                	<input type="hidden" name="mod" value="finance" >
                	<input type="hidden" name="ac" value="account" >
                    <table class="search-tab">
                        <tr>
                            <th width="40">名称:</th>
                            <td><input class="common-text" placeholder="" name="name" value="<?php echo $condition['name'];?>" id="name" type="text"></td>
                            <th width="80">收款类型:</th>
                            <td>
                                <select name="type" id="type">
                                    <option value="">全部</option>
                                    <?php foreach ($accountType_arr as $key=>$val){
                                    	$selected = $condition['type'] && $key==$condition['type'] ? 'selected="selected"' : '';
                                    ?>
                                    <option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
                                    <?php }?>
                                </select>
                            </td>
                            <th width="80">收款开户人:</th>
                            <td><input class="common-text" placeholder="" name="holder" value="<?php echo $condition['holder'];?>" id="holder" type="text"></td>
                            <!--<th width="60">收款渠道:</th>
                            <td><input class="common-text" placeholder="" name="channel" value="<?php echo $condition['channel'];?>" id="channel" type="text"></td>
                            <th width="40">收款账号:</th>
                            <td><input class="common-text" placeholder="" name="account" value="<?php echo $condition['account'];?>" id="account" type="text"></td>
                            <th width="40">开户地址:</th>
                            <td><input class="common-text" placeholder="" name="address" value="<?php echo $condition['address'];?>" id="address" type="text"></td>-->
                            <th width="70">状态:</th>
                            <td>
                                <select name="status" id="status">
                                    <option value="" <?php if(!isset($condition['status']) || $condition['status']=='' )  {echo 'selected="selected"';}?>>全部</option>
                                    <option value="0" <?php if(isset($condition['status']) && $condition['status']=='0' ) {echo 'selected="selected"';}?>>禁用</option>
                                    <option value="1" <?php if(isset($condition['status']) && $condition['status']=='1' ) {echo 'selected="selected"';}?>>启用</option>
                                </select>
                            </td>
                            
                            <td><input class="btn btn-primary btn10" name="" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
        	<span></span>
              <div class="result-title">
                    <div class="result-list">
                        <a href="/index.php?app=admin&mod=finance&ac=accountEdit" target="mainFrame"><i class="icon-font"></i>添加账户</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th style="width:10%;">名称</th>
                            <th style="width:10%;">收款类型</th>
                            <th style="width:10%;">收款渠道</th>
                            <th style="width:10%;">收款开户人</th>
                            <th style="width:10%;">收款账号</th>
                            <th style="width:10%;">用户组</th>
                            <th style="width:10%;">二维码</th>
                            <th style="width:10%;">状态</th>
                            <th style="width:15%;">操作</th>
                        </tr>
                        <?php foreach ($dataList as $data){?>
                        <tr>
                            <td><?php echo $data['name'];?></td>
                            <td><?php echo $data['type_caption'];?></td>
                            <td><?php echo $data['channel'];?></td>
                            <td><?php echo $data['holder'];?></td>
                            <td><?php echo $data['account'];?></td>
                            <td><?php echo \Model\User\Group::idToName($data['group_id'])?></td>
                            <td><img src="<?php echo $data['path'];?>" style="height:50px"/></td>
                            <td><?php echo $data['status_caption'];?></td>
                            <td>
                                <a class="link-update" href="/index.php?app=admin&mod=finance&ac=accountEdit&id=<?php echo $data['id'];?>" target="mainFrame">修改</a>
                                <a class="link-del" href="javascript:delAccount('/index.php?app=admin&mod=finance&ac=accountDel&id=<?php echo $data['id'];?>');">删除</a>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                    <div class="list-page"><?php echo $pager;?></div>
                </div>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
 function delAccount(url){
		if(confirm('您是否要删除该收款账户？删除后不可恢复')){
			location.href = url;
		}
	}
</script>
<!--include file "admin_bottom.php"-->