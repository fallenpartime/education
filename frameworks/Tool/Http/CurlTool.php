<?php
/**
 * Curl工具
 * Date: 2018/7/13
 * Time: 14:16
 */
namespace Frameworks\Tool\Http;

class CurlTool
{
    /**
     * 异步请求
     * @param $url
     * @param null $data_string
     * @return mixed
     */
    public static function httpPost($url, $data_string=null) {

        $ssl = false;
        if (starts_with($url, 'https')) {
            $ssl = 2;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        $httpheaders = array(
            'Content-Type: application/json; charset=utf-8',
        );
        if (!empty($data_string)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $httpheaders[] = 'Content-Length: ' . strlen($data_string);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheaders);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $ssl);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * 异步请求
     */
    public static function httpPostAsync($url, $data)
    {
        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_TIMEOUT_MS, 1000);
        $result = json_decode(curl_exec($ch));

        return $result;
    }

    /**
     * 同步请求-数组
     */
    public static function httpPostArr($url, $data)
    {
        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * get请求
     */
    public static function httpGet($url, $data_string=null) {
        $ssl = false;
        if (starts_with($url, 'https')) {
            $ssl = 2;
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $httpheaders = array(
            'Content-Type: application/json; charset=utf-8',
        );
        if (!empty($data_string)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $httpheaders[] = 'Content-Length: ' . strlen($data_string);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheaders);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $ssl);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * curl判断判断远程图片或文件是否存在
     * @param $url
     * @return bool
     */
    public static function urlExists($url)
    {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        //不下载
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        //设置超时
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($http_code == 200) {
            return true;
        }

        return false;
    }

    public static function getUrlContents($url)
    {
        if (ini_get("allow_url_fopen") == "1") {
            return file_get_contents($url);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result =  curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}