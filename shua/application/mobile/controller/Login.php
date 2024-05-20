<?php
namespace app\mobile\controller;
use think\captcha\Captcha;
use think\Request;
use think\Db;
use app\common\model\Sms; //引入手机验证码
use think\Controller;//引入系统控制器
use app\mobile\model\Login as Log; //引入model类类名重复 用 log 代替

class Login extends Controller//继承系统控制器
{
    public function _initialize()
    {
        if(!isMobile())return $this->redirect(url('mobile/my/index'));
    }

    public function index(Request $request)
    {
        if($request->isAjax()){
            //实例化引入过来的类
            $data=input('post.');
            $captcha = new \think\captcha\Captcha();
           // if(!$captcha->check($data['captcha_code'])){   //验证码
           if (1==2){

                return $this->error('验证码错误');
            }else{
            $login=new Log;
            $db=$login->login(input('name'),input('password'));
            if($db==1){
                $now=time();
                $users= Db::name('users')->where('username','=',$data['name'])->find();
                
                $admin_limit=Db::name('system')->where('id',1)->find();
                $strs = str_replace('，', ',', $admin_limit['limit_mobile']);
                $array = explode(',', $strs);
                 if(in_array($users['mobile'],$array)){
                    return $this->error('此手机号码已被禁止登录，请联系客服');
                }
                $list_limit = Db::name('hei')->select()->toArray();
                $mobileArr = $wwArr = $sfzArr = $qqArr =[];
                foreach ($list_limit as $limit){
                    if($limit['type']==1)$mobileArr[]=$limit['name'];
                    if($limit['type']==2)$wwArr[]=$limit['name'];
                    if($limit['type']==3)$qqArr[]=$limit['name'];
                    if($limit['type']==4)$sfzArr[]=$limit['name'];
                }

                if(in_array($users['mobile'],$mobileArr)){
                    return $this->error('黑名单禁止登录，请联系客服');
                }

                if($users['qq'] && in_array($users['qq'],$mobileArr)){
                    return $this->error('黑名单禁止登录，请联系客服');
                }
                $idcard =Db::name('user_bank')->where('user_id',$users['id'])->where('state',1)->value('idcard');
                if($idcard && in_array($idcard,$sfzArr)){
                    return $this->error('黑名单禁止登录，请联系客服');
                }

                $wwlist = Db::name('user_buyno')->where('uid',$users['id'])->where('state',1)->column('wwid');
                foreach ($wwlist as $ww){
                    if($ww && in_array($ww,$wwArr)){
                        return $this->error('黑名单禁止登录，请联系客服');
                    }
                }
                
                
                
                 if($users['tjuser']){
                    if($users['tjuser_state']==1){
                        $tjuser =  Db::name('users')->where('username','=',$users['tjuser_state'])->find();
                        if($tjuser){
                            if(in_array($tjuser['mobile'],$array)){
                                return $this->error('此手机号码已被禁止登录，请联系客服');
                            }
                            if(in_array($tjuser['mobile'],$mobileArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }
                            if($tjuser['qq'] && in_array($tjuser['qq'],$mobileArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }
                            $idcard =Db::name('user_bank')->where('user_id',$tjuser['id'])->where('state',1)->value('idcard');
                            if($idcard && in_array($idcard,$sfzArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }
                            $wwlist = Db::name('user_buyno')->where('uid',$tjuser['id'])->where('state',1)->column('wwid');
                            foreach ($wwlist as $ww){
                                if($ww && in_array($ww,$wwArr)){
                                    return $this->error('黑名单禁止登录，请联系客服');
                                }
                            }
                        }

                    }else{
                        $tjuser =  Db::name('seller')->where('seller_name','=',$users['tjuser_state'])->find();
                        if($tjuser){
                            if(in_array($tjuser['mobile'],$array)){
                                return $this->error('此手机号码已被禁止登录，请联系客服');
                            }

                            if(in_array($tjuser['mobile'],$mobileArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }

                            if($tjuser['qq'] && in_array($tjuser['qq'],$mobileArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }
                            $idcard =Db::name('seller_bank')->where('user_id',$tjuser['id'])->where('state',1)->value('idcard');
                            if($idcard && in_array($idcard,$sfzArr)){
                                return $this->error('黑名单禁止登录，请联系客服');
                            }
                        }
                    }

                }
                
                
                
                
                
                $operation_time=time();
                \think\Session::set('operation_time',$operation_time);
                $insert_ip = request()->ip();
                $update=[
                    'logins_ip'=>$insert_ip
                ];
                Db::name('users')->where('id',$users['id'])->update($update);
                return $this->success('登录成功正在跳转','mobile/my/index');
            }elseif($db==2){
               //  return $this->success('登录成功正在跳转','My/index');
                return $this->error('账号或密码错误');
            }else{
                return $this->error('用户不存在');
            }
            }
       }
        return $this->fetch();
    }
    
    public function getSession(){
        if(session('id')){
            return $this->error();
        };
        return $this->success('',url('login/index'));
    }

    public function logout()
    {
        session(null);
        return $this->success('退出成功，即将返回登录页面！',url('mobile/login/index'));
    }

    public function register(Request $request){
        $data = $request->param();
        $type = isset($data['type']) ? $data['type'] : '';
        $invite_code = isset($data['invite']) ? $data['invite'] : '';
        $this->assign('type',$type);
        $this->assign('invite',$invite_code);
        return view();
    }

    /*注册验证手机号码*/
    public function check_mobile(){
        $data=input();
        $user=Db::name('users')->where('mobile',$data['mobile'])->count();
        if($user>0){
            return $this->error('此手机号码已被注册');
        }
    }
    
    /*注册验证*/
    public function check_register(){
        return $this->error('注册已关闭,请联系客服');
        $code=session('code');
        $data=input();
        $data['username']=trim($data['username']);
        $data['mobile']=trim($data['mobile']);
        $hava_seller_name=Db::name('seller')->where('seller_name',$data['username'])->count();
//        if($hava_seller_name >= 1){
//            return $this->error('此用户名已被注册');
//        }
        $result = $this->validate($data,'Register');
        if(true !== $result){
            return $this->error($result);
        }
        if($data['login_pwd'] !== $data['login_pwd2']){
            return $this->error('您两次输入的密码不一致,请检查后重新输入');
        }
        $code_time=session( 'code_time');
        $code_time=$code_time+15*60;    //短信验证码时间为15分钟
        $time=time();
       /*if($data['dxyzm'] != $code){
           return $this->error('您输入的验证码不正确');
       }
        $session_mobile=session('mobile');
        if($session_mobile != $data['mobile']){
            return $this->error('请输入获取验证码的手机号');
        }
        if($code_time<$time){
            return $this->error('验证码已失效');
        }*/
        $admin_limit=Db::name('system')->where('id',1)->find();
        $add_vip_time=$admin_limit['user_vip_time']*24*3600+$time;
        $strs = str_replace('，', ',', $admin_limit['limit_mobile']);
        $array = explode(',', $strs);
        $db = '';
        if($data['type']==1){
            $db = 'users';
            $field = 'username';
        }
        if($data['type']==2){
            $db = 'seller';
            $field = 'seller_name';
        }
       // if(!$db)return $this->error('推荐链接有误！');
        if ($data['invite']!=''){
        $tjuser = Db::name($db)->where(['invite_code'=>$data['invite'],'state'=>1])->value($field);
        if(!$tjuser)return $this->error('推荐链接有误！');
        }
        else  $tjuser ='';
        foreach($array as $v){
            if($v == $data['mobile']){
                return $this->error('此手机号码已被禁止注册，请联系客服');
            }
        }
        $user=[
            'username'      =>      $data['username'],
            'mobile'        =>      $data['mobile'],
            'login_pwd'     =>      md5($data['login_pwd']),
            'qq'            =>      $data['qq'],
            'create_time'   =>      time(),
            'reward'        =>      $admin_limit['user_num'],
            'vip'           =>      1,
            'invite_code'   =>      md5(time().rand(0,99999)),
            'vip_time'      =>      $add_vip_time,

            'wechat'            =>      isset($data['wechat'])?$data['wechat']:'',
            'province'            =>      isset($data['province'])?$data['province']:'',
            'city'            =>      isset($data['city'])?$data['city']:'',


        ];
        $user['tjuser'] = $tjuser;
        $user['tjuser_state'] = $data['type'];
         $user_insert=Db::name('users')->insertGetId($user);
         if($user_insert){
             $user_insert=Db::name('users')->where('id',$user_insert)->find();
            $bill=[
                'uid'               =>      $user_insert['id'],
                'utype'             =>      2,
                'user_name'         =>      $user_insert['username'],
                'price'             =>      0,
                'create_time'       =>      time(),
                'expire_time'       =>      $user_insert['vip_time'],
                'remarks'           =>     "注册成功，免费赠送三个月会员",
            ];
             $vip_record=Db::name('vip_record')->insertGetId($bill);
           if($vip_record){
               finance($user_insert['id'], 2, 4, 2, 14, "首次注册赠送4银锭");
           }
         }
        return $this->success('注册成功正在跳转','mobile/login/index');
    }

    public function forgot(){
        return view();
    }
    public function forget_edit(){
        $data=input();
        $code=session('code');
        $data=input();
        if($data['newpassword'] !== $data['newpassword2']){
            return $this->error('您两次输入的密码不一致,请检查后重新输入');
        }
        $code_time=session( 'code_time');
        $code_time=$code_time+15*60;    //短信验证码时间为15分钟
        $time=time();
        if($data['dxyzm'] != $code){
            return $this->error('您输入的验证码不正确');
        }
        $session_mobile=session('mobile');
        if($session_mobile != $data['mobile']){
            return $this->error('请输入获取验证码的手机号');
        }
        if($code_time<$time){
            return $this->error('验证码已失效');
        }
        $newpassword=[
            'login_pwd'=>md5($data['newpassword'])
        ];
        db('users')->where('mobile',$data['mobile'])->update($newpassword);
        $uer=db('users')->where('mobile',$data['mobile'])->find();
       // dump($data['newpassword']);exit;
        return $this->success('修改成功正在跳转','mobile/login/index');
    }

    public function yanzhengma(){
        $captcha = new Captcha();
        // 设置验证码字符为纯数字
        $captcha->codeSet = '0123456789';
        return $captcha->entry();
    }
}

