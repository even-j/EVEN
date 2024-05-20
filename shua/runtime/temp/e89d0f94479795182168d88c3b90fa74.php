<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"/www/wwwroot/xbt.com/pubic/../application/buy/view/my/add_buyno.html";i:1698557938;s:60:"/www/wwwroot/xbt.com/application/buy/view/public/header.html";i:1698557938;s:58:"/www/wwwroot/xbt.com/application/buy/view/public/left.html";i:1574049114;s:60:"/www/wwwroot/xbt.com/application/buy/view/public/footer.html";i:1698558181;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>小白兔</title>
    <link rel="stylesheet" type="text/css" href="/static/buy/element-ui/lib/theme-chalk/index.css" />
    <!-- 页面内容CSS -->
    <link rel="stylesheet" type="text/css" href="/static/buy/css/pageCss/maiHaoAdd.css"/>
    <link rel="Shortcut Icon" type="image/x-icon" href="/static/buy/img/index.png" />
    <script src="/static/buy/js/vue-2.6.10.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/element-ui/lib/index.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/js/axios.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/buy/js/jquery-1.12.4.min.js" type="text/javascript" charset="utf-8"></script>
    <style>
        .el-image-viewer__close {
            top: 15%!important;
            right: 25%!important;
        }
    </style>
    <script type="text/javascript">
        $(function() {
            // 手机号正则表达式
            var phoneReg = /^1[3-9]\d{9}$/;
            /* 初始化一个Vue */
            var vm = new Vue({
               el: ".center_box",
                data: function() {
                    return {
                        /* 示例图 */
                        urlwwimg:"/static/buy/img/wwimg3.png",
                        urlzfb:"/static/buy/img/zhifubaorenzheng.png",
                        urlip:"/static/buy/img/ipbd.png",
                        urlidcard:"/static/buy/img/idcard.png",
                        /* 表格数据 */
                        tableData: [
                            <?php if(is_array($buyno) || $buyno instanceof \think\Collection || $buyno instanceof \think\Paginator): $i = 0; $__LIST__ = $buyno;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            {
                            wwid: `<?php echo $vo['wwid']; ?>`,
                                id:`<?php echo $vo['id']; ?>`,
                            name: `<?php echo $vo['addressname']; ?>`,
                            address: `<?php echo $vo['addresspro']; ?><?php echo $vo['addresscity']; ?><?php echo $vo['addressarea']; ?><?php echo $vo['addresstext']; ?>`,
                            zhifubaoNum: `<?php echo $vo['alipayimg']; ?>`,
                                addressphone:`<?php echo $vo['addressphone']; ?>`,
                                beizhu:`<?php echo $vo['note']; ?>`,
                            maiHaoZhuangTai: "<?php if($vo['state'] ==0): ?>未审核<?php elseif($vo['state'] ==1): ?>审核通过<?php else: ?>已禁用<?php endif; ?>"
                            },
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                         ],
                        /* 输入框value值 */
                        vipNameValue: "",
                        shouHuoNameValue: "",
                        addressValue: "",
                        phoneValue: "",
                        yzmValue: "",
                        renZhengValue: "",
                        IDNameValue: "",
                        /* 省市区地址 */
                        mapJson: "/static/buy/json/map.json",
                        provinceValue: "",
                        cityValue: "",
                        blockValue: "",
                        provinceList: [],
                        cityList: [],
                        blockList: [],
                        newCity: [],
                        newBlock: [],
                        /* 省市常用登陆地 */
                        provinceValue2: "",
                        cityValue2: "",
                        blockValue2: "",
                        provinceList2: [],
                        cityList2: [],
                        blockList2: [],
                        newCity2: [],
                        newBlock2: [],
                        /* 图片的上传数量 */
                        picNum: 1,
                        /* 图片用变量保存路径 */
                        localFile: "",
                        localFile2: "",
                        localFile3: "",
                        localFile4: "",
                        /* 验证码按钮是否禁用 */
                        isDisabled: false
                    }
                },
                    computed: {
                        // 大图预览
                        srcList2: function () {
                            return ["/static/buy/img/zhifubaorenzheng.png"]
                        },
                        srcWwimg:function(){
                            return ["/static/buy/img/wwimg1.png","/static/buy/img/wwimg2.png","/static/buy/img/wwimg3.png"]
                        },
                        srcZfb:function(){
                            return ["/static/buy/img/zhifubaorenzheng.png"]
                        },
                        srcIp:function(){
                            return ["/static/buy/img/ipbd.png"]
                        },
                        srcIdcard:function(){
                            return ["/static/buy/img/idcard.png"]
                        }
                    },
                methods: {
                    /* 下拉菜单事件 */
                    handleOpen: function(key, keyPath) {
                        // console.log(key, keyPath);
                    },
                    handleClose: function(key, keyPath) {
                        // console.log(key, keyPath);
                    },
                    /* 消息弹框事件 */
                    openMsg: function() {
                        this.$alert("暂无消息通知", "个人通知", {

                        });
                    },
                /* 获取图片的base64路径 */
                    handleChange: function (e) {
                    var that=this;

                        var reader = new FileReader();
                        reader.readAsDataURL(e.raw);
                        reader.onload = function () {
                            // console.log(reader.result);
                            that.localFile=reader.result
                        }
                    },
                    handleChange2: function (e) {
                        var that=this;
                        var reader = new FileReader();
                        reader.readAsDataURL(e.raw);
                        reader.onload = function () {
                            // console.log(reader.result);
                            that.localFile2=reader.result
                        }
                    },
                    handleChange3: function (e) {

                    var that=this;
                        var reader = new FileReader();
                        reader.readAsDataURL(e.raw);
                        reader.onload = function () {
                            // console.log(reader.result);
                            that.localFile3=reader.result
                        }
                    },
                    handleChange4: function (e) {

                    var that=this;
                        var reader = new FileReader();
                        reader.readAsDataURL(e.raw);
                        reader.onload = function () {
                            // console.log(reader.result);
                            that.localFile4=reader.result
                        }
                    },

                    /* 删除图片 */
                    handleRemove(file) {
                        // console.log(file);
                    },
                    handleRemove2(file) {
                        // console.log(file);
                    },
                    handleRemove3(file) {
                        // console.log(file);
                    },
                    handleRemove4(file) {
                        // console.log(file);
                    },
                    /* 删除表格一行的方法 */
                    deleteTable: function(index) {
                        console.log(index);
                        var that = this;
                        that.$confirm("是否修改?", "温馨提示", {
                            confirmButtonText: "确定",
                            cancelButtonText: "取消",
                            type: "warning"
                        }).then(function() {

                            var id=that.tableData[index].id;
                            //alert(id);
                            location.href="<?php echo url('my/edit_buyno','','',true); ?>/id/"+id;
                        }).catch(function() {
                            that.$message({
                                type: "info",
                                message: "您取消了操作"
                            });
                        });
                    },
                    /* 失败的弹框 */
                    alertError: function(e) {
                        this.$message.error(e);
                    },
                    /* 成功的弹框 */
                    alertSuccess: function(e) {
                        this.$message({
                            message: e,
                            type: "success"
                        });
                    },
                    /* 给表格上色 */
                    cellStyle: function (e) {
                        var beizhu = this.tableData[e.rowIndex].beizhu;
                        beizhu = Number(beizhu);

                        if (e.columnIndex === 5) {
                                return "color:red;";
                        }

                    },
                    /* 省市区三级联动方法 */
                    // 获取json数据,三级联动
                    getCityData: function() {
                        var that = this;
                        axios.get(this.mapJson).then(function(response) {
                            if (response.status === 200) {
                                var data = response.data;
                                // 省市区数据分类
                                for (var item in data) {
                                    if (item.match(/0000$/)) {
                                        that.provinceList.push({
                                            id: item,
                                            value: data[item],
                                            children: []
                                        });
                                    } else if (item.match(/00$/)) {
                                        that.newCity.push({
                                            id: item,
                                            value: data[item],
                                            children: []
                                        });
                                    } else {
                                        that.newBlock.push({
                                            id: item,
                                            value: data[item]
                                        });
                                    }
                                }
                                // 分类市级
                                for (var index in that.provinceList) {
                                    for (var index1 in that.newCity) {
                                        if (that.provinceList[index].id.slice(0, 2) === that.newCity[index1].id.slice(0, 2)) {
                                            that.provinceList[index].children.push(that.newCity[index1]);
                                        }
                                    }
                                }
                                // 分类区级
                                for (var item1 in that.newCity) {
                                    for (var item2 in that.newBlock) {
                                        if (that.newBlock[item2].id.slice(0, 4) === that.newCity[item1].id.slice(0, 4)) {
                                            that.newCity[item1].children.push(that.newBlock[item2]);
                                        }
                                    }
                                }
                            } else {
                                // console.log(response.status);
                            }
                        }).catch(function(error) {
                            // console.log(typeof + error);
                        })
                    },
                    // 选省
                    chooseProvince: function(e) {
                        for (var index2 in this.provinceList) {
                            if (e === this.provinceList[index2].id) {
                                this.provinceValue=this.provinceList[index2].value;
                                this.cityList = this.provinceList[index2].children;
                                this.cityValue = this.provinceList[index2].children[0].value;
                                this.blockList = this.provinceList[index2].children[0].children;
                                this.blockValue = this.provinceList[index2].children[0].children[0].value;
                                this.newId = this.blockList[0].id;
                            }
                        }
                        console.log(this.provinceValue);
                    },
                    // 选市
                    chooseCity: function(e) {
                        for (var index3 in this.newCity) {
                            if (e === this.newCity[index3].id) {
                                this.cityValue =this.newCity[index3].value;
                                this.blockList = this.newCity[index3].children;
                                this.blockValue = this.newCity[index3].children[0].value;
                                this.newId = this.blockList[0].id;
                            }
                        }
                        console.log(this.cityValue);
                    },
                    // 选区
                    chooseBlock: function(e) {
                        for(var index4 in this.newBlock){
                            if (e === this.newBlock[index4].id) {
                                this.blockValue = this.newBlock[index4].value;
                                this.newId = e;
                            }
                        }
                        console.log(this.blockValue);
                    },

                    /* 省市区2级联动方法 */
                    // 获取json数据,2级联动
                    getCityData2: function() {
                        var that = this;
                        axios.get(this.mapJson).then(function(response) {
                            if (response.status === 200) {
                                var data = response.data;
                                // 省市区数据分类
                                for (var item in data) {
                                    if (item.match(/0000$/)) {
                                        that.provinceList2.push({
                                            id: item,
                                            value: data[item],
                                            children: []
                                        });
                                    } else if (item.match(/00$/)) {
                                        that.newCity2.push({
                                            id: item,
                                            value: data[item],
                                            children: []
                                        });
                                    } else {
                                        that.newBlock2.push({
                                            id: item,
                                            value: data[item]
                                        });
                                    }
                                }
                                // 分类市级
                                for (var index in that.provinceList2) {
                                    for (var index1 in that.newCity2) {
                                        if (that.provinceList2[index].id.slice(0, 2) === that.newCity2[index1].id.slice(0, 2)) {
                                            that.provinceList2[index].children.push(that.newCity2[index1]);
                                        }
                                    }
                                }
                                // 分类区级
                                for (var item1 in that.newCity2) {
                                    for (var item2 in that.newBlock2) {
                                        if (that.newBlock2[item2].id.slice(0, 4) === that.newCity2[item1].id.slice(0, 4)) {
                                            that.newCity2[item1].children.push(that.newBlock2[item2]);
                                        }
                                    }
                                }
                            } else {
                                // console.log(response.status);
                            }
                        }).catch(function(error) {
                            // console.log(typeof + error);
                        })
                    },
                    // 选省
                    chooseProvince2: function(e) {
                        for (var index2 in this.provinceList2) {
                            if (e === this.provinceList2[index2].id) {
                                this.provinceValue2=this.provinceList2[index2].value;
                                this.cityList2 = this.provinceList2[index2].children;
                                this.cityValue2= this.provinceList2[index2].children[0].value;
                                this.blockList2 = this.provinceList2[index2].children[0].children;
                                this.blockValue2 = this.provinceList2[index2].children[0].children[0].value;
                                this.newId2 = this.blockList2[0].id;
                            }
                        }
                        console.log(this.provinceValue2);
                    },
                    // 选市
                    chooseCity2: function(e) {
                        for (var index3 in this.newCity2) {
                            if (e === this.newCity2[index3].id) {
                                this.cityValue2 =this.newCity2[index3].value;
                                this.blockList2 = this.newCity2[index3].children;
                                this.blockValue2 = this.newCity2[index3].children[0].value;
                                this.newId2 = this.blockList2[0].id;
                            }
                        }
                        console.log(this.cityValue2);
                    },
                    getMobile:function(){
                        var mobile = this.phoneValue;
                        var that = this;
                        $.post("<?php echo url('buy/my/check_mobile'); ?>",{mobile:mobile},function(res){
                            if(res.code==1){
                                vm.alertSuccess(res.msg);
                            }else{
                                vm.alertError(res.msg);
                                that.phoneValue = '';
                            }
                        })
                    },

                    click:function(){
                        if(!this.IDNameValue) return vm.alertError("旺旺ID不能为空");
                        if(!this.provinceValue2) return vm.alertError("请选择旺旺常用登陆地");
                        if(!this.shouHuoNameValue) return vm.alertError("收货人姓名不能为空");
                        if(!this.provinceValue) return vm.alertError("收货地址不能为空");
                        if(!this.addressValue) return vm.alertError("收货地址详细信息不能为空");
                        if(!this.phoneValue) return vm.alertError("收货人手机号码不能为空");
                        if(!this.renZhengValue) return vm.alertError("支付宝认证姓名不能为空");
                        if(!this.yzmValue) return vm.alertError("请输入手机号验证码");
                        $.ajax({
                            type : 'POST',
                            url : "<?php echo url('buy/my/addbuyno'); ?>",
                            async : true,
                            data : {
                                "wwid":vm.IDNameValue,
                                "provinceValue2":vm.provinceValue2,
                                "cityValue2":vm.cityValue2,
                                "shouHuoNameValue":vm.shouHuoNameValue,
                                "provinceValue":vm.provinceValue,
                                "cityValue":vm.cityValue,
                                "blockValue":vm.blockValue,
                                "addressValue":vm.addressValue,
                                "mobile":vm.phoneValue,
                                "dxyzm":vm.yzmValue,
                                "renZhengValue":vm.renZhengValue,
                                'img1':vm.localFile,
                                'img2':vm.localFile2,
                                'img3':vm.localFile3,
                                'img4':vm.localFile4
                            },
                            success : function(data){
                                if(data.code==1){
                                    vm.alertSuccess(data.msg);
                                    setTimeout(function(){
                                        return location.href=data.url;
                                    },3000)

                                }else{
                                    return vm.alertError(data.msg);
                                }
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert(XMLHttpRequest.status + "," + textStatus);
                            }
                        });
                     // alert(123);
                    },
                },
                /* 页面初始化的时候加载函数 */
                created: function() {
                    this.getCityData();
                    this.getCityData2();
                }
            });

            /* 初始化jQuery */
            $(function() {

                /* 调用jQuery实现选择导航栏效果 */
                $(".title a").click(function() {
                    $(this).addClass("add_color").siblings().removeClass("add_color");
                });

                /* 默认添加账号这栏不显示 */
                $(".add_num").hide();

                /* 点击切换显示和隐藏 */
                $(".user_content .web_gonggao .gonggao_row .gonggao_top").click(function() {
                    $(this).children().addClass("select_on").end().siblings().children().removeClass("select_on");
                    var index = $(this).index();
                    if (index === 0) {
                        $(".add_num").hide().siblings(".shuju_table").show();
                        $(".msg_title_txt").text("买号添加");
                    } else {
                        $(".add_num").show().siblings(".shuju_table").hide();
                        $(".msg_title_txt").text("添加账号");
                    }
                });

                /* 验证码倒计时 */
                $(".sendBtn").click(function() {
                    if(!vm.phoneValue) return vm.alertError("收货人手机号码不能为空");
                    if (!phoneReg.test(vm.phoneValue)) {
                        return vm.alertError("手机号码格式不规范,请检查后重新输入");}
                    $.ajax({
                        type : 'POST',
                        url : "<?php echo url('way/send_code'); ?>",
                        async : true,
                        data : {
                            "mobile":vm.phoneValue,
                            "dxyzm":vm.yzmValue
                        },
                        success : function(data){
                            // vm.alertError(data.msg);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(XMLHttpRequest.status + "," + textStatus);
                        }
                    });
                    var num = 60;
                    var that = this;
                    var timer = setInterval(function() {
                        num--;
                        vm.isDisabled = true;
                        $(that).html("还剩 " + num + " 秒");
                        if (num <= 0) {
                            clearInterval(timer);
                            $(that).html("重新发送");
                            vm.isDisabled = false;
                        } else if (num === 59) {
                            vm.alertSuccess("验证码发送成功,若接收失败请耐心等待一分钟后点击重新发送");
                        }
                    }, 1000);
                });

            });

        });

    </script>
</head>
<body>
<div class="container">

    <!-- 头部 -->
    <link rel="stylesheet" type="text/css" href="/static/buy/css/header.css"/>
<div class="header" v-cloak>
    <div class="top_bg">
        <div class="top">
            <div class="top_left">
                <span><?php echo $users['username']; ?></span>
                <span class="gang">|</span>
                <a href="javascript:void (0)" class="tuichu">退出</a>
            </div>
            <div class="top_right">
                <span>本金: <span class="price_color"><?php echo $users['balance']; ?></span>元</span>
                <span class="gang">|</span>
                <span>银锭: <span class="price_color"><?php echo $users['reward']; ?></span>银锭</span>
            </div>
        </div>
    </div>
    <!-- 导航栏 -->
    <div class="nav">
        <a href="javascript:"><img class="logo" src="/static/buy/img/logo.png" alt="小白兔"/></a>
        <div class="title">
            <a href="<?php echo url('my/index'); ?>" <?php if(!(empty($topnav) || (($topnav instanceof \think\Collection || $topnav instanceof \think\Paginator ) && $topnav->isEmpty()))): if($topnav == 1): ?>class="add_color" <?php endif; endif; ?>>
            个人中心</a>
            <a href="<?php echo url('helpcenter/index'); ?>" <?php if(!(empty($topnav) || (($topnav instanceof \think\Collection || $topnav instanceof \think\Paginator ) && $topnav->isEmpty()))): if($topnav == 2): ?>class="add_color" <?php endif; endif; ?>> 帮助中心</a>
            <a href="<?php echo url('money/withsilver',['hnav'=>'3','nav'=>'2']); ?>" <?php if(!(empty($topnav) || (($topnav instanceof \think\Collection || $topnav instanceof \think\Paginator ) && $topnav->isEmpty()))): if($topnav == 3): ?>class="add_color" <?php endif; endif; ?>> 银锭充值</a>
            <a href="<?php echo url('money/withdrawal',['hnav'=>'3','nav'=>'1']); ?>" <?php if(!(empty($topnav) || (($topnav instanceof \think\Collection || $topnav instanceof \think\Paginator ) && $topnav->isEmpty()))): if($topnav == 4): ?>class="add_color" <?php endif; endif; ?>> 提现</a>
            <a href="<?php echo url('task/index',['hnav'=>'2','nav'=>'1']); ?>" <?php if(!(empty($topnav) || (($topnav instanceof \think\Collection || $topnav instanceof \think\Paginator ) && $topnav->isEmpty()))): if($topnav == 5): ?>class="add_color" <?php endif; endif; ?>>
            任务大厅</a>
        </div>
        <div class="bell_btn">
            <button type="button" class="el-button el-button--default el-button--small is-circle"
                    @click="dialogVisible = true">
                <i class="el-icon-bell"></i>
            </button>
            <div class="red_type" v-show="num > 0">{{num}}</div>
        </div>
        <div class="renwu_btn">
            <button class="el-button el-button--danger" @click="maketask">
                <img class="renwu_img" src="/static/buy/img/renwu.png" alt=""/>
                <span>继续任务</span>
            </button>
        </div>
    </div>
    <!-- 弹出框内容 -->
    <el-dialog :visible.sync="dialogVisible" title="个人通知">
        <div v-if="state==1" class="center_box1">

            <!-- 左边部分 -->
            <div class="left_box1">
                <div class="left_table">
                    <div :class="[index>=1?'hide_border':'',currentIndex===index?'selectOn':'']"
                         @click="handleClickTable(index)"
                         class="left_table_item"
                         v-for="(item,index) in tableList">
                        <div class="txt">
                            <span :class="item.look==1?'type_color':''"></span>
                            <p v-html="item.title"></p>
                        </div>
                        <div class="time">
                            <i class="el-icon-time"></i>
                            <span v-html="item.create_time"></span>
                        </div>
                    </div>
                </div>
                <div class="fenye">
                    <el-pagination @current-change="setPage"
                                   :page-size="5"
                                   :total="total" :pager-count="5"
                                   background
                                   layout="prev, pager, next">
                    </el-pagination>
                </div>
            </div>

            <!-- 右边盒子部分 -->
            <div class="right_box1">
                <h1 v-html="title" style="margin-bottom: 20px;"></h1>
                <div>
                    <p style="text-indent: 2em" v-html="content">
                </div>
                <div style="display: flex;flex-direction: column;align-self: flex-end;justify-content: flex-end; margin-top: 20px">
                    <p v-html="admin"></p>
                    <p v-html="datetime"></p>
                </div>
            </div>

        </div>
                <div v-else>
                    <span class="masigg">暂无通知</span>
                </div>
    </el-dialog>

</div>
<script>
    $(function () {

        vm=new Vue({
            el: ".header",
            data: function () {
                return {
                    curIndex: 0,
                    dialogVisible: false,
                    tableList: [],
                    currentIndex: 0,
                    title: "",
                    state: 0,
                    content: "",
                    datetime: "",
                    admin: "",
                    total: 0,
                    page: 1,
                    num:0
                }
            },
            methods: {
                maketask:function(){
                    location.href="<?php echo url('task/maketask'); ?>"
                },
                /* 消息弹框事件 */
                openMsg: function () {
                    this.dialogTableVisible = true;
                    if(this.tableList.length > 0){
                        this.setData(0);
                    }
                },
                handleClickTable: function (index) {
                    this.title = this.tableList[index].title;
                    this.content = this.tableList[index].content;
                    this.datetime = this.tableList[index].create_time;
                    this.admin = this.tableList[index].author;
                    this.currentIndex = index;
                    this.tableList[index].type = true;
                    this.setData(index);
                },
                getData: function () {
                    var that = this;
                    $.post("<?php echo url('index/msg'); ?>", {page: that.page}, function (res) {
                        if (res.code == 1) {
                            console.log(res);
                            that.tableList = res.data.list;
                            that.total = res.data.total;
                            that.num = res.data.num;
                            if (that.tableList.length > 0) {
                                that.state = 1;
                                that.title = that.tableList[0].title;
                                that.content = that.tableList[0].content;
                                that.datetime = that.tableList[0].create_time;
                                that.admin = that.tableList[0].author;
                            } else {
                                that.state = 0;
                            }
                        } else {
                            layer.msg('网络错误');
                        }
                    })
                },
                panduan:function(){
                    var timer = setInterval(function(){
                        $.post("<?php echo url('login/getSession'); ?>",{},function(res){
                            console.log(12);
                            if(res.code==1){
                                location.href="<?php echo url('login/index'); ?>";
                            }else{

                            }
                        })
                    },10000);
                },
                setData:function(index){
                    var that = this;
                    if(this.tableList[index].look==1)return;
                    that.tableList[index].look=1;
                    $.post("<?php echo url('index/setMsg'); ?>", {id: this.tableList[index].id}, function (res) {
                        if(res.data == 0)that.num=0;
                    })
                },
                setPage(val) {
                    this.page = val;
                    console.log(123);
                    this.getData();
                },
                addColor: function (index) {
                    this.curIndex = index;
                },

                /* 失败的弹框 */
                alertError: function (e) {
                    this.$message.error(e);
                },
                /* 成功的弹框 */
                alertSuccess: function (e) {
                    this.$message({
                        message: e,
                        type: "success"
                    });
                },
            },
            created() {
                this.getData();
                this.panduan();
            }
        });

        $(function () {
            $(".tuichu").click(function () {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('login/logout'); ?>",
                    async: true,
                    data: {
                        "aoData": 'aaaa',//测试数据,
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.code == 1) {
                            vm.alertSuccess(data.msg);
                            setTimeout(function () {
                                return location.href = data.url;
                            }, 3000)

                        } else {
                            return vm.alertError(data.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(XMLHttpRequest.status + "," + textStatus);
                    }
                });
            });
        });

    });
</script>



    <!-- 内容部分 -->
    <div class="center_box">
        <!-- 下拉列表 -->
        <style>
    [v-cloak]{
        display: none!important;
    }
</style>
<div class="a_path" v-cloak>
    <el-col class="select_box">
        <el-menu default-active="<?php if(!(empty($hnav) || (($hnav instanceof \think\Collection || $hnav instanceof \think\Paginator ) && $hnav->isEmpty()))): ?><?php echo $hnav; ?>-<?php echo $nav; endif; ?>" class="el-menu-vertical-demo" unique-opened>
            <el-submenu default-openeds index="1">
                <template slot="title">
                    <img alt="" src="/static/buy/img/zhanghaoxinxi.png" style="width: 20px;margin-right: 5px;" />
                    <span>账号信息</span>
                </template>
                <el-menu-item-group class="el_menu1">
                    <el-menu-item class="el_item" index="1-1">基本信息</el-menu-item>
                    <el-menu-item  class="el_item" index="1-2">账号提现</el-menu-item>
                    <el-menu-item  class="el_item" index="1-3">买号添加</el-menu-item>
                    <el-menu-item  class="el_item" index="1-4">会员VIP</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="2">
                <template slot="title">
                    <img alt="" src="/static/buy/img/renwuqingkuang.png" style="width: 20px;margin-right: 5px;" />
                    <span>任务情况</span>
                </template>
                <el-menu-item-group class="el_menu2">
                    <el-menu-item  class="el_item" index="2-1">任务领取</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="3">
                <template slot="title">
                    <img alt="" src="/static/buy/img/zijinguanli.png" style="width: 20px;margin-right: 5px;" />
                    <span>资金管理</span>
                </template>
                <el-menu-item-group class="el_menu3">
                    <el-menu-item  class="el_item" index="3-1">提现</el-menu-item>
                    <el-menu-item  class="el_item" index="3-2">银锭充值</el-menu-item>
                    <el-menu-item  class="el_item" index="3-3">提现记录</el-menu-item>
                    <!--<el-menu-item  class="el_item" index="3-4">佣金记录</el-menu-item>-->
                </el-menu-item-group>
            </el-submenu>
            <el-submenu index="4">
                <template slot="title">
                    <img alt="" src="/static/buy/img/haoyouyaoqing.png" style="width: 20px;margin-right: 5px;" />
                    <span>好友邀请</span>
                </template>
                <el-menu-item-group class="el_menu4">
                    <el-menu-item  class="el_item" index="4-1">邀请好友</el-menu-item>
                    <el-menu-item  class="el_item" index="4-2">邀请记录</el-menu-item>
                </el-menu-item-group>
            </el-submenu>
        </el-menu>
    </el-col>
</div>

<script>
    $(function () {
        $(".select_box .el_menu1 .el_item").click(function () {
            var index=$(this).index();
            //console.log($(this).attr("index"));
            if(index===0){
                location.href="<?php echo url('my/information',['hnav'=>'1','nav'=>'1']); ?>"
            }
            else if(index===1){
                location.href="<?php echo url('my/withdrawal',['hnav'=>'1','nav'=>'2']); ?>"
            }
            else if(index===2){
                location.href="<?php echo url('my/add_buyno',['hnav'=>'1','nav'=>'3']); ?>"
            }else if(index===3){
                location.href="<?php echo url('my/vip_record',['hnav'=>'1','nav'=>'4']); ?>"
            }

        });
        $(".select_box .el_menu2 .el_item").click(function () {
            var index=$(this).index();
            console.log($(this).attr("index"));
            if(index===0){
                location.href="<?php echo url('task/index',['hnav'=>'2','nav'=>'1']); ?>"
            }

        });
        $(".select_box .el_menu3 .el_item").click(function () {
            var index=$(this).index();
            console.log($(this).attr("index"));
            if(index===0){
                location.href="<?php echo url('money/withdrawal',['hnav'=>'3','nav'=>'1']); ?>"
            }
            else if(index===1){
                location.href="<?php echo url('money/withsilver',['hnav'=>'3','nav'=>'2']); ?>"
            }
            else if(index===2){
                location.href="<?php echo url('money/drawal_record',['hnav'=>'3','nav'=>'3']); ?>"
            }
            else if(index===3){
                location.href="<?php echo url('money/commission',['hnav'=>'3','nav'=>'4']); ?>"
            }
        });
        $(".select_box .el_menu4 .el_item").click(function () {
            var index=$(this).index();
            console.log($(this).attr("index"));
            if(index===0){
                location.href="<?php echo url('recommend/index',['hnav'=>'4','nav'=>'1']); ?>"
            }
            else if(index===1){
                location.href="<?php echo url('recommend/record',['hnav'=>'4','nav'=>'2']); ?>"
            }
            else if(index===2){
                location.href="<?php echo url('money/drawal_record',['hnav'=>'3','nav'=>'3']); ?>"
            }
            else if(index===3){
                location.href="<?php echo url('money/commission',['hnav'=>'3','nav'=>'4']); ?>"
            }
        });
    });
</script>



        <!-- 右边盒子部分 -->
        <div class="right_box">
            <!-- 基本信息标题 -->
            <div class="msg_title">
                <p>个人中心&nbsp;/&nbsp;账号信息&nbsp;/&nbsp;<span class="msg_title_txt">买号添加</span></p>
            </div>
            <div class="user_content">

                <!-- 买号添加 -->
                <div class="web_gonggao">
                    <div class="gonggao_row">
                        <div class="gonggao_top">
                            <a href="javascript:;" class="select_on">买号信息</a>
                        </div>
                        <div class="gonggao_top">
                            <a href="javascript:;">添加账号</a>
                        </div>
                    </div>
                </div>

                <!-- 数据列表 -->
                <div class="shuju_table">
                    <el-table :data="tableData" border style="width: 100%;" :cell-style="cellStyle">
                        <el-table-column prop="wwid" label="旺旺ID" align="center">
                        </el-table-column>
                        <el-table-column prop="name" label="收货人" align="center">
                        </el-table-column>
                        <el-table-column prop="address" label="收货地址" align="center">
                        </el-table-column>
                        <el-table-column prop="addressphone" id="addressphone" label="收货人手机号码" align="center">
                        </el-table-column>

                        <!--</el-table-column>-->
                        <el-table-column prop="maiHaoZhuangTai" label="买号状态" align="center">
                        </el-table-column>
                        <el-table-column prop="beizhu" label="备注"  align="center">
                        </el-table-column>
                        <el-table-column label="操作"  align="center">
                            <template slot-scope="scope">
                                <el-button icon="el-icon-edit" @click="deleteTable(scope.$index)">信息修改</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                    <p style="color: red">提示：买号提交审核后，平台预计在24小时内完成审核操作，只有审核通过的买号才能接手任务 (最多允许绑定3个买号，一个买号每天只能接4单任务)</p>
                </div>

                <!-- 添加账号 -->
                <div class="add_num">

                    <!-- 旺旺信息 -->
                    <el-card shadow="always" >
                        <div slot="header" class="clearfix">
                            <span>旺旺信息</span>
                        </div>
                        <!-- 旺旺常用登陆地 -->
                        <div class="card_item">
                            <p class="card_item_p">*旺旺常用登陆地:</p>
                            <div class="card_col">
                                <div class="card_region">
                                    <el-select class="card_select" v-model="provinceValue2" @change="chooseProvince2" placeholder="请选择省份">
                                        <el-option v-for="item in provinceList2" :key="item.id" :label="item.value" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <el-select class="card_select" v-model="cityValue2" @change="chooseCity2" placeholder="请选择城市">
                                        <el-option v-for="item in cityList2" :key="item.id" :label="item.value" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <p class="card_col_p">请选择该旺旺经常登录的城市或地区,一经选择后,所有买号对应的收货地址必须和旺旺登录的常用的登录地保持一直,绑定后无法自行修改,请谨慎选择</p>
                            </div>
                        </div>
                        <!-- 旺旺ID -->
                        <div class="card_item">
                            <p class="card_item_p">*旺旺ID:</p>
                            <div class="card_col">
                                <el-input class="card_item_input"  placeholder="请填写旺旺ID" v-model="IDNameValue" clearable>
                                </el-input>
                                <p class="card_col_p">请填写该买号使用的旺旺ID，绑定后无法修改，严禁绑定相似的买号。</p>
                            </div>
                        </div>
                        <!-- 旺旺档案截图 -->
                        <div class="card_item" style="position: relative;">
                            <p class="card_item_p">*旺旺档案截图:</p>
                            <div class="card_col">
                                <el-upload ref="unload" action="<?php echo url('my/upload'); ?>" list-type="picture-card" :on-remove="handleRemove"
                                            :on-change="handleChange" :limit="1" :auto-upload="false">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                                <p style="color: red;" class="card_col_p">请登录淘宝APP，点击“我的淘宝-必备工具、互动参与-客服小蜜-发送“评价管理”点“评价管理（电脑版）”截图即可，所绑定买号必须和截图上一致。绑定成功后无法自行修改,请谨慎选择。</p>
                            </div>

                            <div style="position: absolute;font-size: 14px;right: 245px;top: 40px;width: 100px;">
                                <p style="font-size: 14px;color:red;font-family: 微弱雅黑;word-wrap: break-word">
                                    点击右边的示例图，查看教程。
                                </p>
                            </div>
                            <!-- 大图预览 -->
                            <div class="pic_view" style="position:absolute;right:80px;top:10px;">
                                <div class="demo-image__preview">
                                    <el-image
                                            style="width: 100px; height: 100px"
                                            :src="urlwwimg"
                                            :preview-src-list="srcWwimg">
                                    </el-image>
                                </div>
                                <p style="text-align: center;font-size: 14px;font-family: 微弱雅黑;">示例图</p>
                            </div>

                        </div>
                        <!-- IP地址截图 -->
                        <div class="card_item" style="position: relative;">
                            <p class="card_item_p">*IP地址截图:</p>
                            <div class="card_col">
                                <el-upload ref="unload" action="string" list-type="picture-card" :on-remove="handleRemove2"
                                            :on-change="handleChange2" :limit="1" :auto-upload="false">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
<!--                                <el-button type="success" style="margin-left: 50px;" @click="activeUpload2">点击上传</el-button>-->
                                <p class="card_col_p">进入 <a href="https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=1&tn=baidu&wd=IP&oq=baidu&rsv_pq=ee2087fd00028c96&rsv_t=4939y6%2B8ncAF%2FhDptaeZVcuRUgqjjewro3Fx7f66eUlBadaQU47NdY8SBvc&rqlang=cn&rsv_enter=1&rsv_sug3=2&rsv_sug1=2&rsv_sug7=100&rsv_sug2=0&inputT=889&rsv_sug4=889"
                                                            style="text-decoration: none;color: red;" target="_blank">www.baidu.com</a> ,搜索"IP"截图本机IP</p>
                            </div>

                            <!-- 大图预览 -->
                            <div class="pic_view" style="position:absolute;right:80px;top:10px;">
                                <div class="demo-image__preview">
                                    <el-image
                                            style="width: 100px; height: 100px"
                                            :src="urlip"
                                            :preview-src-list="srcIp">
                                    </el-image>
                                </div>
                                <p style="text-align: center;font-size: 14px;font-family: 微弱雅黑;">示例图</p>
                            </div>

                        </div>
                    </el-card>

                    <!-- 基本信息 -->
                    <el-card shadow="always" style="margin-top: 30px;">
                        <div slot="header" class="clearfix">
                            <span>基本信息</span>
                        </div>
                        <!-- 收货人姓名 -->
                        <div class="card_item">
                            <p class="card_item_p">*收货人姓名:</p>
                            <div class="card_col">
                                <el-input class="card_item_input" placeholder="请输入收货人姓名" v-model="shouHuoNameValue" clearable>
                                </el-input>
                                <p class="card_col_p">绑定多个买号必须使用不同身份认证的支付宝账号,支付宝认证姓名只允许输入6个字以内的中文</p>
                            </div>
                        </div>
                        <!-- 收货人地址 -->
                        <div class="card_item">
                            <p class="card_item_p">*收货人地址:</p>
                            <div class="card_col">
                                <div class="card_region">
                                    <el-select class="card_select" v-model="provinceValue" @change="chooseProvince" placeholder="请选择省份">
                                        <el-option v-for="item in provinceList" :key="item.id" :label="item.value" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <el-select class="card_select" v-model="cityValue" @change="chooseCity" placeholder="请选择城市">
                                        <el-option v-for="item in cityList" :key="item.id" :label="item.value" :value="item.id">
                                        </el-option>
                                    </el-select>
                                    <el-select class="card_select" v-model="blockValue" @change="chooseBlock" placeholder="请选择地区">
                                        <el-option v-for="item in blockList" :key="item.id" :label="item.value" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </div>
                                <el-input class="card_item_input" placeholder="请输入收货人地址" v-model="addressValue" clearable style="width: 490px;">
                                </el-input>
                                <p class="card_col_p">填写的街道地址必须详细到"门牌号",否则不予通过;第二个买号的收货地址与第一个买号的地址,必须是不同县的或者不同区的</p>
                            </div>
                        </div>
                        <!-- 收货人手机 -->
                        <div class="card_item">
                            <p class="card_item_p">*收货人手机号:</p>
                            <div class="card_col">
                                <el-input class="card_item_input" placeholder="请输入手机号" v-model="phoneValue" clearable maxlength="11" @blur="getMobile()">
                                </el-input>
                                <p class="card_col_p">该手机号必须与您支付宝上认证的手机号码一致；否则不予审核通过</p>
                            </div>
                        </div>
                        <!-- 手机验证码 -->
                        <div class="card_item">
                            <p class="card_item_p">*手机验证码:</p>
                            <div style="margin-bottom: 20px;">
                                <el-input class="card_item_input" placeholder="请输入验证码" v-model="yzmValue" clearable maxlength="6">
                                </el-input>
                                <el-button type="primary" style="margin-left: 20px;" class="sendBtn" :disabled="isDisabled">发送验证码</el-button>
                            </div>
                        </div>
                        <!-- 支付宝认证姓名 -->
                        <div class="card_item">
                            <p class="card_item_p">*支付宝认证姓名:</p>
                            <div class="card_col">
                                <el-input class="card_item_input" placeholder="请输入支付宝认证姓名" v-model="renZhengValue" clearable>
                                </el-input>
                                <p class="card_col_p">绑定多个买号必须使用不同身份认证的支付宝账号，支付宝认证姓名只允许输入6个字以内的中文</p>
                            </div>
                        </div>
                    </el-card>

                    <!-- 支付宝信息 -->
                    <el-card shadow="always" style="margin-top: 30px;">
                        <div slot="header" class="clearfix">
                            <span>支付宝信息</span>
                        </div>
                        <!-- 身份证正面截图 -->
                        <div class="card_item" style="position: relative;">
                            <p class="card_item_p">*身份证正面截图:</p>
                            <div class="card_col">
                                <el-upload ref="unload" action="string" list-type="picture-card" :on-remove="handleRemove3"
                                            :on-change="handleChange3" :limit="1" :auto-upload="false">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
<!--                                <el-button type="success" style="margin-left: 50px;" @click="activeUpload3">点击上传</el-button>-->
                                <p class="card_col_p">身份证正面拍照,身份证信息必须清晰可见,身份证姓名必须和您填写的支付宝实名制姓名一致。此照片仅用于小白兔审核买号使用。</p>
                            </div>

                            <!-- 大图预览 -->
                            <div class="pic_view" style="position:absolute;right:80px;top:10px;">
                                <div class="demo-image__preview">
                                    <el-image
                                            style="width: 100px; height: 100px"
                                            :src="urlidcard"
                                            :preview-src-list="srcIdcard">
                                    </el-image>
                                </div>
                                <p style="text-align: center;font-size: 14px;font-family: 微弱雅黑;">示例图</p>
                            </div>

                        </div>
                        <!-- 支付宝实名认证 -->
                        <div class="card_item" style="position: relative;">
                            <p class="card_item_p">*支付宝实名认证:</p>
                            <div class="card_col">
                                <el-upload ref="unload" action="string" list-type="picture-card" :on-remove="handleRemove4"
                                            :on-change="handleChange4" :limit="1" :auto-upload="false">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
<!--                                <el-button type="success" style="margin-left: 50px;" @click="activeUpload4">点击上传</el-button>-->
                                <p class="card_col_p">请登录您的"支付宝",点击"我的-支付宝昵称",截取您的支付宝"个人信息"作为审核凭证,截图中的姓名必须和您填写的支付宝姓名保持一致、实名制淘宝会员名必须和您上传的旺旺档案截图一致。</p>
                            </div>

                            <!-- 大图预览 -->
                            <div class="pic_view" style="position:absolute;right:80px;top:10px;">
                                <div class="demo-image__preview">
                                    <el-image
                                            style="width: 100px; height: 100px"
                                            :src="urlzfb"
                                            :preview-src-list="srcZfb">
                                    </el-image>
                                </div>
                                <p style="text-align: center;font-size: 14px;font-family: 微弱雅黑;">示例图</p>
                            </div>

                        </div>
                    </el-card>

                    <!-- 按钮 -->
                    <div class="btn_row">
                        <el-button class="saveBtn" type="primary"  @click="click">保存</el-button>
                        <el-button class="cancelBtn" type="primary">取消</el-button>
                    </div>

                    <!-- 温馨提示 -->
                    <el-alert title="温馨提示" type="warning" show-icon>
                        <p>1.您绑定的账号需满足<span style="color:red;">注册时间超过3个月、实名认证、信誉等级3心以上、信誉大于2钻的买号注册时间要超过3年，好评率大于99%的安全号:</span></p>
                        <p>2.淘宝|天猫可绑定3个买号，每个买号要求绑定不同的收货信息(收货人姓名 .地址，联系电话均要求不同并且真实有效，能联系上买手本人，同事或者亲戚);</p>
                        <p>3.平台填写的收货信息，务必和淘宝网下单时收货信息保持一致，否则将封闭您的小白兔账号，并没收所有佣金:</p>
                        <p>4.所有绑定的收货地址必须真实有效，因买手原因造成商家真实发货且由于地址原因包裹丢失，损失由买手承担:</p>
                        <p>5.必须确保绑定的所有买号收货地址与登录IP地址保持一致， 建议还可以写公司地址，亲属地址，朋友地址;</p>
                        <p>6.买号提交审核后，平台预计在24小时内完成审核操作。</p>
                        <p>7.提供1个月前的购物记录截图上显示的地址必须和平台绑定的收货地址一致。</p>
                    </el-alert>
                </div>
            </div>
        </div>
    </div>

    <!-- 底部 -->
    <!-- 底部 -->
<link rel="stylesheet" type="text/css" href="/static/buy/css/footer.css" />
<div class="commonFooter">
    <div class="contents">
        <!--©版权所有: <a href="#">安徽云梭网络科技有限公司</a>-->
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        技术支持: <a style="margin-right: 70px;" href="#">小白兔 </a>

    </div>
</div>

</div>

</body>
</html>
