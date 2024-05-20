<?php


namespace app\common\controller;


use think\Controller;
use think\Db;
use think\Exception;
use think\Request;
use think\Config;
use think\Image;
use OSS\OssClient;
use OSS\Core\OssException;

class aliyunOss extends Controller
{
    /**
     * 单文件上传
     *  $file = request()->file('file');  //获取到上传的文件
     * @param $file
     * @return array|string
     */
    static public function uploadFile($file,$up_dir= 'uploads/')
    {
        $img_path = $up_dir.date('Y/m/d').'/';
        import('alioss.autoload',EXTEND_PATH,'.php');
        $resResult = Image::open($file);
        // 尝试执行
        try {
            $config = Config::get('aliyunOss'); //获取Oss的配置
            //实例化对象 将配置传入
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
            //这里是有sha1加密 生成文件名 之后连接上后缀
            $fileName = sha1(date('YmdHis', time()) . uniqid()) . '.' . $resResult->type();
            //执行阿里云上传
            $result = $ossClient->uploadFile($config['Bucket'], $img_path.$fileName, $file->getInfo()['tmp_name']);
            $arr = [
                'address' => $result['info']['url'],
            ];
            return $arr;
        } catch (OssException $e) {
            return $e->getMessage();
        }
        //将结果输出
        dump($arr);
    }


    /**
     * Function 图片上传到阿里云Oss
     * User 扬风
     * Date 2020/6/29
     * Time 9:46 PM
     * @param $file
     * @param string $up_dir
     * @return array
     */
    static public function uploadImg($file,$up_dir= 'uploads/')
    {
        $img_path = $up_dir.date('Y/m/d').'/';
        import('alioss.autoload',EXTEND_PATH,'.php');
        $resResult = Image::open($file);
        // 尝试执行
        try {
            $config = Config::get('aliyunOss'); //获取Oss的配置
            //实例化对象 将配置传入
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
            //这里是有sha1加密 生成文件名 之后连接上后缀
            $fileName = sha1(date('YmdHis', time()) . uniqid()) . '.' . $resResult->type();
            //执行阿里云上传
            $result = $ossClient->uploadFile($config['Bucket'], $img_path.$fileName, $file->getInfo()['tmp_name']);
            $url = str_replace('http://tfkzpic.oss-cn-hangzhou.aliyuncs.com','',$result['info']['url']);
            return ['code'=>1,'data'=>$url];
        } catch (OssException $e) {
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
    }


    static public function uploadVideo($file,$up_dir= 'uploads/')
    {

        $uploadFolder = '/' . $up_dir . '/'; // 上传文件路径
        $rule         = ['size' => 104857600, 'ext' =>array('mp3','mp4','gif','mov')];
        $checkFile = $file->check($rule);
        if ($checkFile !== true) {
            return array('status' => 0, 'mess' => $file->getError());
        }

        $info = $file->move(ROOT_PATH . 'pubic' . $uploadFolder);
        if ($info) {
            $url = $uploadFolder . $info->getSaveName();
            return ['code'=>1,'data'=>$url];
        } else {
            return ['code'=>0,'msg'=>$file->getMessage()];
        }


        $img_path = $up_dir.date('Y/m/d').'/';
        import('alioss.autoload',EXTEND_PATH,'.php');
        // 尝试执行
        try {
            $config = Config::get('aliyunOss'); //获取Oss的配置
            //实例化对象 将配置传入
            $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
            //这里是有sha1加密 生成文件名 之后连接上后缀
            $fileName = sha1(date('YmdHis', time()) . uniqid()) . '.' . 'mp4';
            //执行阿里云上传
            $result = $ossClient->uploadFile($config['Bucket'], $img_path.$fileName, $file->getInfo()['tmp_name']);
            $url = str_replace('http://tfkzpic.oss-cn-hangzhou.aliyuncs.com','',$result['info']['url']);
            return ['code'=>1,'data'=>$url];
        } catch (OssException $e) {
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
    }
    /**
     * Function 图片base64上传到阿里云Oss
     * User 扬风
     * Date 2020/6/29
     * Time 9:46 PM
     * @param $file
     * @param string $up_dir
     * @return array
     */
    static public function uploadBase64($object,$up_dir= 'uploads/')
	{
        $config = Config::get('aliyunOss'); //获取Oss的配置
        //实例化对象 将配置传入
       // $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
	   //  $filename = $up_dir.date('Y/m/d').'/';
		try {
			if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$object,$result)) {
				$ext = $result[2];

                $new_file = 'uploads' . DS . 'goods' . DS.date('Ymd').'/';;

                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                if(!file_exists($new_file)){
                    mkdir($new_file, 0700);
                }
                //组合图片地址(图片存放地址+图片名+图片后缀)
                $new_file =  $new_file.time().rand(0,9999).".$ext";
                //保存图片
                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $object)))){
                    //返回图片地址路径
                    return '/'.$new_file;
                }

                /*
				$name = sha1(date('YmdHis', time()) . uniqid());
				$filurl = $filename."{$name}.{$ext}";
				$content = base64_decode(str_replace($result[1], '', $object));
				$res = $ossClient->putObject($config['Bucket'], $filurl,$content);
				$filurl = '/'.$filurl;*/
			}else{
				throw new Exception('请上传正确base64');
			}
			
		} catch (OssException $e) {
			return false;
		}
		return $new_file;
	}
	
	  static public function uploadPic($file,$mkdirname='')
    {

        $uploadFolder = '/' . $mkdirname . '/'; // 上传文件路径
        $rule         = ['size' => 1048576, 'ext' =>array('jpg','jpeg','gif','png')];
            $checkFile = $file->check($rule);
            if ($checkFile !== true) {
                return array('status' => 0, 'mess' => $file->getError());
            }

            $info = $file->move(ROOT_PATH . 'pubic' . $uploadFolder);
            if ($info) {
                $url = $uploadFolder . $info->getSaveName();
                return ['code'=>1,'data'=>$url];
            } else {
                return ['code'=>0,'msg'=>$file->getMessage()];
            }
    }

    /**
     * 多图片上传
     * @param $file_arr
     * @return array|string
     */
    static public function uploadarr($file_arr,$up_dir= 'uploads/'){
        $img_path = $up_dir.date('Y/m/d').'/';
        import('alioss.autoload',EXTEND_PATH,'.php');
        foreach($file_arr as $key=>$val){
            $resResult = Image::open($val);
            // 尝试执行
            try {
                $config = Config::get('aliyunOss'); //获取Oss的配置
                //实例化对象 将配置传入
                $ossClient = new OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
                //这里是有sha1加密 生成文件名 之后连接上后缀
                $fileName = sha1(date('YmdHis', time()) . uniqid()) . '.' . $resResult->type();
                //执行阿里云上传
                $result = $ossClient->uploadFile($config['Bucket'], $img_path.$fileName, $val->getInfo()['tmp_name']);
                $arr[$key] = $result['info']['url'];
            } catch (OssException $e) {
                return $e->getMessage();
            }
        }//endforeach
        return $arr;
    }

}