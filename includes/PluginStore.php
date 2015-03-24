<?php

class PluginStore
{
	public function get($inputData=array())
	{

		$limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:15;

		$limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

		$limitPage='/limitPage/'.$limitPage;

		$limitShow='/limitShow/'.$limitShow;

		$orderBy=isset($inputData['orderBy'])?'/orderBy/'.$inputData['orderBy']:'';

		$sortBy=isset($inputData['sortBy'])?'/sortBy/'.$inputData['sortBy']:'desc';

		$orderBy.=$sortBy;

		// /where/id > 10

		$whereQuery=isset($inputData['whereQuery'])?'/where:'.trim($inputData['whereQuery']).'/':'';

		$inCategory=isset($inputData['inCategory'])?'/inCategory/'.$inputData['inCategory']:'';

		$addArgs=$whereQuery.$inCategory.$orderBy.$limitShow.$limitPage;

		$theUrl=NOBLESSECMS_URL.'api/json/plugin'.$addArgs;

		$loadData=Http::getDataUrl($theUrl);


		$loadData=json_decode($loadData,true);

		if(isset($loadData['error']) && $loadData['error']=='yes')
		{
			return false;
		}

		return $loadData['data'];
	}

	public function download()
	{
		$userid=Session::get('userid');

		$resultData=array('error'=>'yes');

		$loadUser=Users::get(array(
			'where'=>"where userid='$userid' AND is_admin='1'"
			));

		if(!isset($loadUser[0]['userid']))
		{
			return json_encode($resultData);
		}

		$fileUrl=Request::get('fileUrl','');

		$fileTitle=Request::get('fileTitle','');

		if(!isset($fileUrl[4]) || !isset($fileTitle[3]))
		{
			return json_encode($resultData);
		}
		if(preg_match('/.*?\.txt/i', $fileUrl))
		{
			$fileData=Http::getDataUrl($fileUrl);

			$fileUrl=trim($fileData);
		}
		File::downloadModule($fileUrl,'contents/plugins/','yes');

		$resultData['error']='no';

		return json_encode($resultData);
	}
}


?>