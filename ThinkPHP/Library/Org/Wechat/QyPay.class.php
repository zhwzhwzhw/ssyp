<?php
namespace Org\Wechat;
//企业付款  封装
class QyPay{
    protected  $appid;
    protected  $appsecret;
    protected $mchid;
    protected $key ;
    protected $ip;
    protected $check_name = 'NO_CHECK';//FORCE_CHECK
    protected $zs1;
    protected $zs2;
    public function __construct($appid = NULL,$appsecret = NULL,$key =NULL,$mchid=NULL){
        $appid = is_null($appid) ? C('APPID') : $appid;
        $appsecret = is_null($appsecret) ? C('APPSECRET') : $appsecret;
        $key = is_null($key) ? C('WX_KEY') : $key;
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->key = $key;
        $this->mchid = is_null($mchid) ? C('MCHID') : $mchid;
        $this->ip = C('SERVER_IP');
        $this->zs1 = ROOT."Public/pay/cert/apiclient_cert.pem";
        $this->zs2 = ROOT."Public/pay/cert/apiclient_key.pem";
    }
    public function pay($amount,$openid,$trade_no,$re_user_name,$desc){
        $dataArr=array();
        $dataArr['amount']=$amount;     //金额  分为单位
        $dataArr['check_name']=$this->check_name;  //是否强制检测姓名
        $dataArr['desc']=$desc;                   //付款描述
        $dataArr['mch_appid']=$this->appid;
        $dataArr['mchid']=$this->mchid;
        $dataArr['nonce_str']=mt_rand(1000000, 9999999);
        $dataArr['openid']=$openid;
        $dataArr['partner_trade_no']=$trade_no;  //可以存放订单号 数组字母组合
        $dataArr['re_user_name']=$re_user_name;  //真实姓名
        $dataArr['spbill_create_ip']=$this->ip; 
        $sign=$this->getSign($dataArr);//getSign($dataArr);见结尾
        
        
        
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        
        $xml = <<<EOT
    <xml>
    <mch_appid>%s</mch_appid>
    <mchid>%s</mchid>
    <nonce_str>%s</nonce_str>
    <partner_trade_no>%s</partner_trade_no>
    <openid>%s</openid>
    <check_name>%s</check_name>
    <re_user_name>%s</re_user_name>
    <amount>%s</amount>
    <desc>%s</desc>
    <spbill_create_ip>%s</spbill_create_ip>
    <sign>%s</sign>
    </xml>
EOT;
        $data = sprintf(
            $xml,
            $dataArr['mch_appid'],
            $dataArr['mchid'],
            $dataArr['nonce_str'],
            $dataArr['partner_trade_no'],
            $dataArr['openid'],
            $dataArr['check_name'],
            $dataArr['re_user_name'],
            $dataArr['amount'],
            $dataArr['desc'],
            $dataArr['spbill_create_ip'],
            $sign
        );
        return $this->curl_cert($data);
    }
    
    private function curl_cert($data){
        $ch = curl_init ();
        $MENU_URL="https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        curl_setopt ( $ch, CURLOPT_URL, $MENU_URL );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        //两个证书（必填，请求需要双向证书。）
        $zs1=$this->zs1;
        $zs2=$this->zs2;
        curl_setopt($ch,CURLOPT_SSLCERT,$zs1);
        curl_setopt($ch,CURLOPT_SSLKEY,$zs2);
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $info = curl_exec ( $ch );
        if (curl_errno ( $ch )) {
            return curl_error ( $ch );
        }
        curl_close ( $ch );
        $xmlObj = simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        $errmsg = (string)$xmlObj->err_code_des;
        if($errmsg){
            return $errmsg;
        }else{
            return true;
        }
    }
    
    
   /**
    * 生成签名的方法
    * @param unknown $Obj
    * @return string
    */
   protected  function getSign($Obj)
    {
        //var_dump($Obj);//die;
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);//方法如下
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $key = $this->key;
        $String = $String."&key=".$key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }
    
   /**
 * 作用：格式化参数，签名过程需要使用
 */
     protected function formatBizQueryParaMap($paraMap, $urlencode)
    {
        //var_dump($paraMap);//die;
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        //var_dump($reqPar);//die;
        return $reqPar;
    }
}