<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>


<form action="<?php echo $reqURL_onLine; ?>" name="doRecharge" method="post" id="doRecharge">

			
    p0_Cmd:<input type='text' name='p0_Cmd' value='<?php echo $var['p0_Cmd']; ?>' style="width:400px;"><br>
    p1_MerId:<input type='text' name='p1_MerId'	value='<?php echo $var['p1_MerId']; ?>' style="width:400px;"><br>
    p2_Order:<input type='text' name='p2_Order'	value='<?php echo $var['p2_Order']; ?>' style="width:400px;"><br>
    p3_Amt:<input type="text" name="p3_Amt"     value='<?php echo $var['p3_Amt']; ?>' style="width:400px;"><br>
    p4_Cur:<input type='text' name='p4_Cur'	value='<?php echo $var['p4_Cur']; ?>' style="width:400px;"><br>
    p5_Pid:<input type='text' name='p5_Pid'	value='<?php echo $var['p5_Pid']; ?>' style="width:400px;"><br>
    p6_Pcat:<input type='text' name='p6_Pcat'	value='<?php echo $var['p6_Pcat']; ?>' style="width:400px;"><br>
    p7_Pdesc:<input type='text' name='p7_Pdesc'	value='<?php echo $var['p7_Pdesc']; ?>' style="width:400px;"><br>
    p8_Url:<input type='text' name='p8_Url'	value='<?php echo $var['p8_Url']; ?>' style="width:400px;"><br>
    p9_SAF:<input type='text' name='p9_SAF'	value='<?php echo $var['p9_SAF']; ?>' style="width:400px;"><br>
    pa_MP:<input type='text' name='pa_MP'	value='<?php echo $var['pa_MP']; ?>' style="width:400px;"><br>
    pd_FrpId:<input type='text' name='pd_FrpId'	value='<?php echo $var['pd_FrpId']; ?>' style="width:400px;"><br>
    pr_NeedResponse:<input type='text' name='pr_NeedResponse'	value='<?php echo $var['pr_NeedResponse']; ?>' style="width:400px;"><br>
    hmac:<input type='text' name='hmac'	value='<?php echo $var['hmac']; ?>' style="width:400px;"><br>
    <input type="submit" value="提交" >
</form>


<script type="text/javascript">
	/*$(function() {
		$('#doRecharge').submit();
	});*/
</script>

</body>
</html>
