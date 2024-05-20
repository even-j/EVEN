<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/index.php?app=admin&mod=index&ac=view" target="_top">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/index.php?app=admin&mod=user&ac=view">用户管理</a><span class="crumb-step">&gt;</span><span><?php echo $nav_title; ?></span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/index.php?app=admin&mod=user&ac=doGroupEdit" method="post"onclick="return validateForm();"  id="myform" name="myform" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>名称：</th>
                                <td><input class="common-text required" id="name" name="name"  value="<?php echo $row['name']; ?>" type="text" /> <i class="tip left pd10"></i></td>
                            </tr>
                            <tr>
                                <th>备注：</th>
                                <td><textarea class="common-textarea required"  id="memo" name="memo" style="width:600px;height:80px;"><?php if($row['memo']){ echo $row['memo']; }?></textarea><i class="tip left pd10"></i></td>

                            </tr>
                            <tr>
                                <th>时间：</th>
                                <td><input class="common-text required" id="add_time" name="add_time"  value="<?php if($row['add_time']){echo date('Y-m-d H:i:s',$row['add_time']);}else{ echo date('Y-m-d H:i:s') ;} ?>" type="text" /> <i class="tip left pd10"></i></td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" name="submit" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form> 
            </div>
        </div>

    </div>
    <!--/main-->
</div>
<script type="text/javascript">
    function validateForm() {
        var name = $('#name');

        if (name.val() == "") {
            name.next().html('名称不能为空');
            return false;
        } else {
            name.next().html('');
        }
         

        return true;
    }
 
</script>
<!--include file "admin_bottom.php"-->