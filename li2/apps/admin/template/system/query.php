<!--include file "admin_include.php"-->
<div class="container clearfix">
    <div class="main-wrap">
        <!--include file "admin_nav.php"-->
        <div class="result-wrap">
            <form action="#" method="post" id="myform" name="myform">
                <div class="config-items">
                    <div class="config-title">
                        <h1><i class="icon-font">&#xe00a;</i>SQL命令行工具</h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
	                    	<tbody>    
	                    		  <tr>
	                    		  	<td height="44" width="100">
	                    		  	表查询
	                    		  	</td>
	                    		  	<td>
	                    		  		<select name="table_name" class="common-select mt10 mb10 mr10" style="width:480px;">
	                    		  			<option value="0">请选择表</option>
	                    		  			<?php foreach ($tables as $key=>$table){?>
	                    		  			<option value="<?php echo($table['Tables_in_peizi']);?>"><?php echo($table['Tables_in_peizi']);?></option>
	                    		  			<?php }?>
	                    		  		</select>
	                    		  	</td>
	                    		  </tr>
						          <tr> 
						            <td height="44" colspan="2" bgcolor="#F9FCEF"><strong>运行SQL命令行： 
						              <input name="querytype" type="radio" class="np" value="0">
						              单行命令（支持查询）&nbsp;&nbsp;
						              <input name="querytype" type="radio" class="np" value="2" checked>
						              多行命令</strong>
						              </td>
						          </tr>
						          
								  <tr> 
						            <td height="118" colspan="2">
									<textarea name="sqlquery" cols="60" rows="10" id="sqlquery" style="width:90%" class="mt10 mb10"></textarea> 
						            </td>
						          </tr>
						          <?php if($msg){?>
						          <tr>
						          <td colspan="2" class="blue"><?php echo $msg;?></td>
						          </tr>
						          <?php }?>
						          <tr> 
						            <td colspan="2" height="53">
						            	<input type="submit" class="btn btn-primary btn50" value="提交">
						            </td>
						          </tr>
					          </tbody>
                         </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>

<!--include file "admin_bottom.php"-->