<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Pay extends Validate{

	protected $rule = [
		'partner' => 'requireIf:alipay,1',
		'pid' => 'requireIf:alipay,1',
		'ali_key' => 'requireIf:alipay,1',
		'rsa' => 'requireIf:alipay,1',
		'pay_sign_key' => 'requireIf:wxpay,1',
		'partner_id' => 'requireIf:wxpay,1',
		'partner_key' => 'requireIf:wxpay,1'
	];

	protected $message = [
		'partner.requireIf' => '支付宝商户账号不能为空',
		'pid.requireIf' => '支付宝pid不能为空',
		'ali_key.requireIf' => '支付宝key不能为空',
		'rsa.requireIf' => '支付宝私钥不能为空',
		'pay_sign_key.requireIf' => '微信paySignKey不能为空',
		'partner_id.requireIf' => '微信partnerId不能为空',
		'partner_key.requireIf' => '微信partnerKey不能为空'
	];

}