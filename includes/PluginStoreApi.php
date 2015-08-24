<?php

class PluginStoreApi
{

	public static function api($action)
	{
		Model::load('api/pluginstore');

		try {
			$result=loadApi($action);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

		return $result;
	}

	public static function get($inputData=array())
	{
		$server_url=SERVER_URL.'api/pluginstore/get';

		$loadData=Http::sendPostTo($server_url,$inputData);


		return $loadData;

	}

	public static function getFileName($url='')
	{
		$fileName='';

        $text=get_headers($url);

        $total=count($text);

        if($total > 1)
        {
        	for ($i=0; $i < $total; $i++) { 
        		if(preg_match('/Content-Disposition: attachment; filename=(.*?)$/i', $text[$i],$match))
        		{
        			$fileName=$match[1];
        		}
        	}
        }

        return $fileName;
	}


	public static function getHTML($inputData=array())
	{
		$loadData=self::get($inputData);

		$inputData=json_decode($loadData,true);

		$tmp=$inputData['data'];

		unset($inputData);

		$inputData=$tmp;



		$total=count($inputData);

		$li='';

		for ($i=0; $i < $total; $i++) { 

			if(!isset($inputData[$i]['title']))
			{
				continue;
			}

			$li.='
			  <!-- Plugin -->
			  <div class="col-lg-6 plugin-store-item">
			    <div class="row">
			      <div class="col-lg-12">
			        <a href="df" target="_blank"><img src="'.$inputData[$i]['previewUrl'].'" class="img-responsive"></a>
			      </div>
			      <div class="col-lg-12">
			        <div class="well">
			          <div class="head-title">
			            <a href="'.$inputData[$i]['url'].'" target="_blank">'.$inputData[$i]['title'].'</a>
			          </div>
			          <div class="content">
			          <p>
			            <img src="'.$inputData[$i]['ratingImage'].'" >
			          </p>
			            '.substr($inputData[$i]['description'], 0,150).'...
			          </div>

			          <div class="more-info text-right">
			            <button type="button" id="btnInstall" data-url="'.$inputData[$i]['downloadUrl'].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-circle-arrow-down"></span> Download</button>
			            <a href="'.$inputData[$i]['url'].'" class="btn btn-success btn-xs" target="_blank"><span class="glyphicon glyphicon-hand-right"></span> More information</a>
			          
			          </div>
			        </div>
			      </div>

			    </div>
			  </div>
			  <!-- Plugin -->  

			';
		}

		return $li;

	}
}
?>