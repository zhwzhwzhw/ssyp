<?php
namespace Org\Wechat;
use Org\Wechat\Base;
/**
 * 素材管理
 * @author hulianping
 * 
 */
class Material extends Base{
	/**
	 * 
	 * @param string  $path   文件磁盘路径
	 * @param string  $type   媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
	 */
	public function add_tem($path,$type){
		$url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->accessToken().'&type='.$type;
		$data = array('media'=>'@'.$path);
		$json = $this->getHttp($url,$data); //模拟post上传
// 		var_dump($this->accessToken());
// 		var_dump($json);
		//$json = $this->testUpload01($url,$path); //模拟post上传
		return $this->jsonData($json, 'media_id');
	}
	
	/**
	 * 添加永久素材
	 */
    public function add_forever($path,$type){
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->accessToken().'&type='.$type;
        $data = array('media'=>'@'.$path);
		$json = $this->getHttp($url,$data); //模拟post上传
		//$json = $this->testUpload01($url,$path); //模拟post上传
		return $this->jsonData($json, 'media_id');
        
        
    }
}