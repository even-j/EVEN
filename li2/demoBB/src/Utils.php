<?php

namespace BBPay\Demo;
class Utils
{
    /**
     * 签名
     *
     * @param array $data 待签名的array
     * @param string $key 签名的key
     * @return string
     */
    public static function make_sign(array $data, string $key): string
    {
        ksort($data);
        $sign_str = '';
        foreach ($data as $pk => $pv) {
            if ($pk == 'sign') {
                continue;
            }
            $sign_str .= "{$pk}={$pv}&";
        }
        $sign_str .= "pri_key={$key}";
        return md5($sign_str);
    }

    /**
     * 加密
     *
     * @param string $data 待加密的字符串
     * @param string $key 加密的key
     * @return string
     */
    public static function encrypt(string $data, string $key): string
    {
        return urlencode(base64_encode(openssl_encrypt($data, 'AES-256-ECB', $key, OPENSSL_RAW_DATA)));
    }

    /**
     * 解密
     *
     * @param string $data 待解密的字符串
     * @param string $key 解密的key
     * @return string
     */
    public static function decrypt(string $data, string $key): string
    {
        return openssl_decrypt(urldecode($data), 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
    }

    /**
     * 发送post请求
     *
     * @param string $url 请求地址
     * @param array $data 请求参数
     * @return mixed
     */
    public static function post(string $url, array $data): mixed
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);
    }
}
