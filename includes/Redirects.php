<?php

class Redirects
{
    public static function to($reUrl = '',$code=0)
    {
        $url = $reUrl;
        if (!preg_match('/http/i', $reUrl)) {
            $url = System::getUrl() . $reUrl;
        }

        if((int)$code > 0)
        Response::headerCode($code);

        header("Location: " . $url);

        die();
    }

	public static function get($inputData=array())
	{
		Table::setTable('redirects');

		Table::setFields('id,from_url,to_url,date_added,status');

		$result=Table::get($inputData);

		return $result;
	}

	public static function insert($inputData=array())
	{
		Table::setTable('redirects');

		$result=Table::insert($inputData,function($insertData){

			if(!isset($insertData['date_added']))
			{
				$insertData['date_added']=date('Y-m-d H:i:s');
			}

			if(isset($insertData['from_url']) && !preg_match('/^http/i', trim($insertData['from_url'])))
			{
				$insertData['from_url']=str_replace(System::getUrl(), '', $insertData['from_url']);
			}

			return $insertData;

		},function($inputData){
			if(isset($inputData['id']))
			{
				Redirects::saveCache($inputData['id']);
			}
		});

		return $result;
	}

	public static function update($listID,$updateData=array())
	{
		Table::setTable('redirects');

		$result=Table::update($listID,$updateData);

		return $result;
	}

	public static function remove($inputIDs=array(),$whereQuery='')
	{
		Table::setTable('redirects');

		$result=Table::remove($inputIDs,$whereQuery);

		return $result;
	}



	public static function checkRedirect()
	{
		$uri=System::getUri();

		if(!isset($uri[1]))
		{
			return false;
		}

		if(!preg_match('/^\//i', $uri))
		{
			$uri='\/'.$uri;
		}

		$hash=md5($uri);

		$savePath=ROOT_PATH.'caches/system/redirects/'.$hash.'.cache';

		if(!file_exists($savePath))
		{
			return false;			
		}

		$loadData=unserialize(file_get_contents($savePath));

		if(is_array($loadData) && isset($loadData['to_url']))
		self::to($loadData['to_url']);
	}

	public static function saveCache($id,$inputData=array())
	{
		if((int)$id==0)
		{
			return false;
		}

		$savePath=ROOT_PATH.'caches/system/redirects/';

		$loadData=array();

		$loadData=self::get(array(
				'cache'=>'no',
				'where'=>"where id='$id'"
				));	

		if(isset($loadData[0]['id']))
		{	
			if(!preg_match('/^\//i', $loadData[0]['from_url']))
			{
				$loadData[0]['from_url']='/'.$loadData[0]['from_url'];
			}

			$savePath.=md5($loadData[0]['from_url']).'.cache';

			File::create($savePath,serialize($loadData[0]));
		}
		
	}
}