<?php
/**
 * 构建支付
 * @author ZhangSan
 */

namespace mypay;

class MyPay
{
    /*
    *加密方法
    */
    public function canencrypt($data, $key)
    {
        if(empty($data)||empty($key))
        {
            return false;
            exit();
        }
        ksort($data);
        $str  = '';
        foreach ($data as $k => $v) 
        {
            $str.="$k=$v&"; 
        }
        $rty = sha1(str_replace("&", "", $str).$key);
        return $rty;
    }
    /*
    *生成随机字符串
    */
    public function rand2($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
         }
         return $string;
    }
}