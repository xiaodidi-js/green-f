<?php 
namespace app\admin\controller;

import('phpqrcode', EXTEND_PATH.'/phpqrcode/');	
class Phpqrcode{
    // 自提点二维码
	public function sinceqrcode($chen='chen', $errorCorrectionLevel='H',$matrixPointSize=4,$logo='../public/static/lvyangtian/logo.png'){
		$QRcode = new \QRcode;
        $value = $chen; //二维码内容 
        $path = '../public/static/sinceqrcode/';
        $filename = $path.time().'.png';
        $QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize,2); 
        $logo = $logo;//准备好的logo图片 
        $QR = $filename;//已经生成的原始二维码图 
        $QR = imagecreatefromstring(file_get_contents($QR)); 
        if($logo !== false){ 
            $logo = imagecreatefromstring(file_get_contents($logo)); 
            $QR_width = imagesx($QR);//二维码图片宽度 
            $QR_height = imagesy($QR);//二维码图片高度 
            $logo_width = imagesx($logo);//logo图片宽度 
            $logo_height = imagesy($logo);//logo图片高度 
            $logo_qr_width = $QR_width / 5; 
            $scale = $logo_width/$logo_qr_width; 
            $logo_qr_height = $logo_height/$scale; 
            $from_width = ($QR_width - $logo_qr_width) / 2; 
            //重新组合图片并调整大小 
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 
            $logo_qr_height, $logo_width, $logo_height); 
        } 
        //输出图片 
        imagepng($QR,$filename);
        $filename = trim($filename,'.');
        return $filename;
	}

    // 二维码商品
    public function qrcodeshop($chen='chen', $errorCorrectionLevel='H',$matrixPointSize=4,$logo='../public/static/lvyangtian/logo.png'){
        $QRcode = new \QRcode;
        $value = $chen; //二维码内容 
        $path = '../public/static/qrcodeshop/';
        $filename = $path.time().'.png';
        $QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize,2); 
        $logo = $logo;//准备好的logo图片 
        $QR = $filename;//已经生成的原始二维码图 
        $QR = imagecreatefromstring(file_get_contents($QR)); 
        if($logo !== false){ 
            $logo = imagecreatefromstring(file_get_contents($logo)); 
            $QR_width = imagesx($QR);//二维码图片宽度 
            $QR_height = imagesy($QR);//二维码图片高度 
            $logo_width = imagesx($logo);//logo图片宽度 
            $logo_height = imagesy($logo);//logo图片高度 
            $logo_qr_width = $QR_width / 5; 
            $scale = $logo_width/$logo_qr_width; 
            $logo_qr_height = $logo_height/$scale; 
            $from_width = ($QR_width - $logo_qr_width) / 2; 
            //重新组合图片并调整大小 
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 
            $logo_qr_height, $logo_width, $logo_height); 
        } 
        //输出图片 
        imagepng($QR,$filename);
        $filename = trim($filename,'.');
        return $filename;
    }
}
