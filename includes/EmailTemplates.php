<?php

class EmailTemplates
{
	public static function getContent($inputName='')
	{
		$savePath=ROOT_PATH.'contents/plugins/fastecommerce/templates/'.$inputName.'.html';
		$subjectPath=ROOT_PATH.'contents/plugins/fastecommerce/templates/subject_'.$inputName.'.html';

		$result=array('subject'=>'','content'=>'');

		if(file_exists($subjectPath))
		{
			$result['subject']=stripslashes(file_get_contents($subjectPath));
		}

		if(file_exists($savePath))
		{
			$result['content']=stripslashes(file_get_contents($savePath));
		}

		return $result;
	}

	
}