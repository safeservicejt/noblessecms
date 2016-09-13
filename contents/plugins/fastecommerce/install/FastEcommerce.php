<?php

class FastEcommerce
{
	public static $setting=array();

	public static $visitor=array();

	public static function index()
	{
		
	}

	public static function before_system_start()
	{

		Discounts::before_frontend_start();

		self::getSetting();

		Lang::setPath(ROOT_PATH.'contents/plugins/fastecommerce/lang/');

		Lang::set(self::$setting['language']);

		Payments::route();

		// if($match=Uri::match('\/?member'))
		// {
		// 	System::setUri('/admincp');
		// }
	
		// if($match=Uri::match('\/?member\/(.*?)'))
		// {
		// 	System::setUri('/admincp/'.$match[1]);
		// }		
	}

	public static function before_frontend_start()
	{			
		if(self::$setting['theme_mobile']=='yes')
		{
			$isMobile=System::isMobile();

			if($isMobile==true)
			{
				System::setTheme(self::$setting['theme_mobile_name']);
			}
		}

		$ip=Http::get('ip');

		Affiliates::checkReferShopping();

		// $country=GeoZone::ipInfo($ip);

		self::$visitor['ip']=$ip;
		
		self::$visitor['useragent']=Http::get('ua');
		
		self::$visitor['refer']=Http::get('refer');
		
		// self::$visitor['country']=$country;

		Cart::loadCache($ip);

		self::theme_header_content();

		self::theme_footer_content();



	}


	public static function money_format($str=0)
	{
		$str=FastEcommerce::$setting['currency_symbol_left'].self::currency_format($str).FastEcommerce::$setting['currency_symbol_right'];

		return $str;
	}

	public static function currency_format($number) 
	{ 
	    $formatted = number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $number)), 2);
	    return $number < 0 ? "({$formatted})" : "{$formatted}";
	} 
	
	public static function before_admincp_start()
	{

		System::setSetting('default_adminpage_method','url');

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		if($owner!='yes')
		{	
			System::setSetting('default_adminpage_url','plugins/privatecontroller/fastecommerce/report/customerstats');

		}
		else
		{
			System::setSetting('default_adminpage_url','plugins/privatecontroller/fastecommerce/report/adminstats');
		}		

		self::admincp_header_content();
	}

	public static function after_insert_user()
	{

	}

	public static function after_remove_user()
	{

	}

	public static function before_register_user()
	{

	}

	public static function admincp_header_content()
	{
		System::defineVar('admincp_navbar_hide_tools','yes');

		$owner=UserGroups::getPermission(Users::getCookieGroupId(),'is_fastecommerce_owner');

		if($owner=='no')
		{	
			$codeHead='<script src="'.System::getUrl().'contents/plugins/fastecommerce/views/coreMembers.js"></script>';

			System::pushVar('admincp_header',$codeHead);
			
			System::pushVar('admincp_navbar_hide_addnew','yes');
			System::pushVar('admincp_navbar_hide_contact','yes');
		}
		else
		{
			$codeHead='<script src="'.System::getUrl().'contents/plugins/fastecommerce/views/core.js"></script>';

			System::pushVar('admincp_header',$codeHead);
		}	
	
				
	}

	public static function admincp_footer_content()
	{
		// $js='<script src="'.ROOT_URL.'contents/plugins/fastecommerce/views/core.js"></script>';

		// System::defineVar('admincp_footer',$js);			
	}

	public static function theme_header_content()
	{
		$codeHead='<link href="'.System::getUrl().'contents/plugins/fastecommerce/css/customFrontEnd.css" rel="stylesheet">';
		$codeHead.='<script src="'.System::getUrl().'contents/plugins/fastecommerce/js/core.js"></script>';


		if(!System::issetVar('site_header'))
		{
			System::defineGlobalVar('site_header',$codeHead);
		}
		else
		{
			System::pushVar('site_header',$codeHead);
		}

	}

	public static function theme_footer_content()
	{
		// $codeHead='<script src="'.System::getUrl().'contents/plugins/fastecommerce/js/core.js"></script>';
		
		// if(!System::issetVar('site_footer'))
		// {
		// 	System::defineGlobalVar('site_footer',$codeHead);
		// }
		// else
		// {
		// 	System::pushVar('site_footer',$codeHead);
		// }
	}

	public static function convertCurrency($number=0,$from='vnd',$to='usd')
	{
		
	}

	public static function convertWeight($number=0,$from='kilogram',$to='pound')
	{

	}

	public static function makeSetting()
	{
		// length_class: Centimeter|Millimeter|Inch
		/*
		1 Centimeter= 0.3937 Inch
		1 Centimeter= 10 Millimeter

		*/
		// weight_class: Kilogram|Gram|Pound |Ounce
		/*
		1 Kilogram= 1000 Gram
		1 Kilogram= 35.274 Ounce
		1 Kilogram= 2.2046 Pound

		*/



		$settingData=array(
			'language'=>'en',

			'theme_mobile'=>'no',
			'theme_mobile_name'=>'',

			'store_name'=>'Your Store',
			'account_email'=>'noreply@yourstore.com',
			'customer_email'=>'noreply@yourstore.com',
			'order_notify_email'=>'noreply@yourstore.com',

			'allow_send_order_notify_to_admin'=>'no',
			'allow_send_order_notify_to_customer'=>'no',

			'store_legal_name'=>'',
			'store_phone'=>'',
			'store_street'=>'',
			'store_city'=>'',
			'system_zipcode'=>'',
			'system_country'=>'',

			'system_default_weight_unit'=>'kg',
			'system_currency'=>'usd',

			'shipping_from_name'=>'',
			'shipping_from_address'=>'',
			'shipping_from_city'=>'',
			'shipping_from_zipcode'=>'',
			'shipping_from_country'=>'',
			'shipping_from_phone'=>'',

			'default_payment_method'=>'paypal',

			'default_vat'=>'0',
			'default_tax'=>'0',

			'allow_reviews'=>'yes',
			'new_review_alert_mail'=>'no',

			'new_order_alert_mail'=>'yes',
			
			'invoice_prefix'=>'Invoice',

			'currency'=>'usd',
			'currency_symbol_left'=>'$',
			'currency_symbol_right'=>'',

			'order_completed'=>0,
			'order_canceled'=>0,
			'order_pending'=>0,
			'customers'=>0,

			'affiliate_withdraw_request'=>0,
			'affiliate_min_money_can_withdraw'=>10,
			'affiliate_percent'=>6,
			'affiliate_rankid'=>1,
			'affiliate_rank_title'=>'Level 1',

			'sales'=>0,

			'length_class'=>'centimeter',
			'length_unit'=>array(
				'centimeter'=>'cm',
				'millimeter'=>'mm',
				'inch'=>'in',
				),

			'weight_class'=>'kilogram',
			'weight_unit'=>array(
				'kilogram'=>'kg',
				'gram'=>'g',
				'ounce'=>'oz',
				'pound'=>'lb',
				),

			'payments'=>array()

			);	

		self::saveSettingData($settingData);

		return $settingData;
	}

	public static function getLengthUnit()
	{
		$class=self::$setting['length_class'];

		$result=self::$setting['length_unit'][$class];

		return $result;
	}

	public static function getWeightUnit()
	{
		$class=self::$setting['weight_class'];

		$result=self::$setting['weight_unit'][$class];

		return $result;
	}

	public static function upAttr($keyName='')
	{
		$val=(double)self::$setting[$keyName]+1;

		self::saveSetting(array(
			$keyName=>$val
			));
	}

	public static function downAttr($keyName='')
	{
		$val=(double)self::$setting[$keyName]-1;

		self::saveSetting(array(
			$keyName=>$val
			));
	}

	public static function resetAttr($keyName='')
	{
		$val=0;

		self::saveSetting(array(
			$keyName=>$val
			));
	}

	public static function allowReview()
	{
		$status=isset(self::$setting['allow_reviews'])?'yes':false;

		return $status;
	}

	public static function getVAT()
	{
		$status=isset(self::$setting['default_vat'])?self::$setting['default_vat']:0;

		return $status;
	}

	public static function getTax()
	{
		$status=isset(self::$setting['default_tax'])?self::$setting['default_tax']:0;

		return $status;
	}

	public static function loadSetting()
	{

		$data=array();

		$fileName=ROOT_PATH.'contents/fastecommerce/setting.cache';

		$data=file_get_contents($fileName);

		if(isset($data[2]))
		$data=unserialize(base64_decode(String::decrypt($data)));

		return $data;
	}

	public static function getSetting($keyName='',$keyValue='')
	{	

		$data=array();

		if(!isset(self::$setting['store_name']))
		{

			$fileName=ROOT_PATH.'contents/fastecommerce/setting.cache';

			if(!file_exists($fileName))
			{
				$data=self::makeSetting();

			}
			else
			{
				$data=file_get_contents($fileName);

				if(isset($data[2]))
				$data=unserialize(base64_decode(String::decrypt($data)));

			}


			self::$setting=$data;
		}
		else
		{
			$data=self::$setting;
		}

		if(!isset($keyName[1]))
		{
			return $data;
		}
		else
		{
			$keyValue=false;

			$keyValue=isset($data[$keyName])?$data[$keyName]:$keyValue;

			return $keyValue;

		}



	}

	public static function saveSetting($inputData=array())
	{
		$data=self::getSetting();

		$keyNames=array_keys($inputData);

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$keyNames[$i];

			$data[$keyName]=$inputData[$keyName];
			
			self::$setting[$keyName]=$inputData[$keyName];

		}
		
		self::saveSettingData($data);

	}

	public static function removeSetting($inputData=array())
	{
		$data=self::getSetting();

		$total=count($inputData);

		for ($i=0; $i < $total; $i++) { 
			$keyName=$inputData[$i];

			unset($data[$keyName]);

		}

		self::saveSettingData($data);
		
	}

	public static function saveSettingData($inputData=array())
	{

		File::create(ROOT_PATH.'contents/fastecommerce/setting.cache',String::encrypt(base64_encode(serialize($inputData))));

	}
}