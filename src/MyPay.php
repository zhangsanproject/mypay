<?php
/**
 * 构建支付
 * @author ZhangSan
 */

namespace mypay;

class MyPay
{
    //用户appid
    public $appid;
    //订单金额(单位分)
    public $price;
    //订单号 自定义唯一订单号
    public $order_num;
    //订单名称
    public $title;
    //订单名称
    public $key;
    /*
    *创建支付
     */
    public function create_order()
    {
        //用户appid
        $data['appid'] = $this->appid;
        $data['price'] = $this->price;
        $data['order_num'] = $this->order_num;
        $data['title'] = $this->title;
        $data['nostr'] = $this->rand2(12);
        $data['sign'] = $this->canencrypt($data,$this->key);
        return $this->curl_post($data,"https://api.51tunan.com/order/order/createaliorder");
    }
    /*
    *查询订单状态
    */
    public function check_order()
    {
        //用户appid
        $data['appid'] = $this->appid;
        $data['out_trade_no'] = $this->order_num;
        $data['nostr'] = $this->rand2(12);
        $data['sign'] = $this->canencrypt($data,$this->key);
        return $this->curl_post($data,"https://api.51tunan.com/order/order/checkorder");
    }
    /*
    *取消订单
    */
    public function cancel_order()
    {
        //用户appid
        $data['appid'] = $this->appid;
        $data['out_trade_no'] = $this->order_num;
        $data['nostr'] = $this->rand2(12);
        $data['sign'] = $this->canencrypt($data,$this->key);
        return $this->curl_post($data,"https://api.51tunan.com/order/order/cancelaliorder");
    }
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
    /**
     * post请求
     */
    public function curl_post($post, $url = 'https://my.canpoint.net/Notification/Api/api_set_notific/') 
    {

    $options = array(CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => false, CURLOPT_POST => true, CURLOPT_POSTFIELDS => $post,);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
    }
}