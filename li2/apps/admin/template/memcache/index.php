<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
       <!--include file "admin_nav.php"-->
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php" method="get">
                    <input type="hidden" name="app" value="admin" >
                    <input type="hidden" name="mod" value="memcache" >
                    <input type="hidden" name="ac" value="view" >
                    <table class="search-tab">
                        <tr>
                            <th width="70">缓存key:</th>
                            <td><input class="common-text" placeholder="缓存key值" name="key" value="<?php echo empty($_GET['key'])?'':$_GET['key']?>" id="" type="text"></td>
                            
                            <td><input class="btn btn-primary btn10" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            
                <div class="result-content" style="width:100%;overflow: auto">
                    <table class="result-tab">
                        <tr>
                           
                            <th style="width:200px">key</th>
                            <th>值</th>
                            <th style="width:80px">操作</th>
                        </tr>
                        <?php foreach ($listdata as $item){?>
                            <tr>
                                
                                <td><?php echo $item['key'] ?></td>
                                <td><?php var_export($item['value'],0);?></td>
                                <td><a href="/?app=admin&mod=memcache&ac=del&key=<?php echo rawurlencode($item['key']); ?>" onclick="return confirm('确认删除')">删除</a></td>
                            </tr>
                        <?php }?>             
                    </table>
                    <div class="list-page"><?php echo $pager;?></div>
                </div>
        </div>
    </div>
    <!--/main-->
</div>
<!--include file "admin_bottom.php"-->