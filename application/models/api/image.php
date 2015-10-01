<?php

function loadApi($action)
{
	switch ($action) {

		case 'post_image':

			if(!$match=Uri::match('post_image\/(\d+)\.(jpg|png)'))
			{
				throw new Exception('Data not valid');
			}

			$fileUrl='';

			try {
				$fileUrl=Post::getImageFromContent($match[1]);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}			

			Redirect::to($fileUrl,301);

			exit;


			break;

		case 'post_thumb':
			
			if(!$match=Uri::match('post_thumb\/(\d+)\.(jpg|png)'))
			{
				throw new Exception('Data not valid');
			}

			$fileUrl='';

			try {
				$fileUrl=System::getUrl().Post::getThumb($match[1]);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}

			Redirect::to($fileUrl,301);

			exit;
			
			break;

	}	
}

?>