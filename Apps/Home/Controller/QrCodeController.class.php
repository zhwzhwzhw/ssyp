<?php
namespace Home\Controller;
use Home\Controller\BaseController;
class QrCodeController extends BaseController {
    //返回二维码地址
    public function qrcodeUrl(){
        $id = I('param.user_id');
        $file = ROOT.'Uploads/_qrcode/'.$id.'.jpeg';
        if(!file_exists($file)){
            $this->QrCode($file, $id);
        }
        echo BASE_URL.'Uploads/_qrcode/'.$id.'.jpeg';exit;
    }
}