<?php

class Import
{
	public function validEmail()
	{
		$result=array();

		$email=trim(Request::get('send_email',''));

		$send_is_check_email_valid=trim(Request::get('send_is_check_email_valid',''));

		$groupid=trim(Request::get('send_groupid',0));

		if(preg_match('/([a-zA-Z0-9_\.\-]+\@\w+\.\w+)/i', $email,$match))
		{
			$email=$match[1];
		}

		if((int)$groupid==0)
		{
			throw new Exception('Chưa chọn nhóm hợp lệ.');
			
		}
		else
		{
			try {

				$msg=array('valid');

				if($send_is_check_email_valid=='yes')
				{
					$msg=Mail::fastVerify($email,true);
				}

				if($msg[0]=='invalid')
				{

					throw new Exception('Email không hợp lệ: '.$msg[1]);
					
				}
				else
				{
					$loadEmail=EmailList::get(array(
						'where'=>"where email='$email'"
						));

					if(!isset($loadEmail[0]['email']))
					{
						$id=EmailList::insert(array(
							'email'=>$email
							));

						EmailGroups::insert(array(
							'emailid'=>$id,
							'groupid'=>$groupid
							));						
					}
					else
					{
						throw new Exception("Email này đã tồn tại trong hệ thống.");
						
					}

				}

			} catch (Exception $e) {

				throw new Exception($e->getMessage());
				
			}			
		}		
	}
	public function importProcess()
	{
		$result=array();

		$fileupload=trim(Request::get('send_file_name',''));

		$filepath=ROOT_PATH.'contents/plugins/emailmarketing/modules/jsuploadem/php/files/'.$fileupload;

		if(!file_exists($filepath))
		{

			throw new Exception('Không tìm thấy file tải lên. Vui lòng kiểm tra lại!');
			
		}
		else
		{
			if(preg_match('/.*?\.txt/i', $fileupload))
			{
				$fileData=file_get_contents($filepath);

				if(preg_match_all('/([a-zA-Z0-9_\_\.]+\@\w+\.\w+)/i', $fileData, $matches))
				{
					$result['data']=$matches[1];
				}
				else
				{
					throw new Exception('Không có email nào trong dữ liệu tải lên.');
					
				}
			}
			elseif(preg_match('/.*?\.xls/i', $fileupload))
			{
				$result['data']=Import::emailFromXLS($filepath);


				if(!isset($result['data'][0][5]))
				{

					throw new Exception('Không có email nào trong dữ liệu tải lên.');
													
				}
			}
			elseif(preg_match('/.*?\.csv/i', $fileupload))
			{
				$result['data']=Import::emailFromCSV($filepath);

				if(!isset($result['data'][0][5]))
				{
					throw new Exception('Không có email nào trong dữ liệu tải lên.');
											
				}
			}
			elseif(preg_match('/.*?\.xlsx/i', $fileupload))
			{
				$result['data']=Import::emailFromXLSX($filepath);

				if(!isset($result['data'][0][5]))
				{
					throw new Exception('Không có email nào trong dữ liệu tải lên.');
													
				}
			}

			unlink($filepath);

		}		

		return $result['data'];
	}

	public function emailFromCSV($filepath='')
	{
		if(!isset($filepath[4]))
		{
			return false;
		}

		if(!file_exists($filepath))
		{
			return false;
		}

		$listEmail=array();

		$totalEmail=0;	

		$row = 1;
		if (($handle = fopen($filepath, "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		        $num = count($data);
		        // echo "<p> $num fields in line $row: <br /></p>\n";
		        $row++;
		        for ($c=0; $c < $num; $c++) {
		            // echo $data[$c] . "<br />\n";

		            $cell=trim($data[$c]);

					if(isset($cell[5]) && preg_match('/([a-zA-Z0-9_\.\-]+\@\w+\.\w+)/i', $cell,$match))
					{
						$listEmail[$totalEmail]=$match[1];

						$totalEmail++;
					}	

		        }
		    }
		    fclose($handle);
		}

		return $listEmail;
	}

	public function emailFromXLSX($filepath='')
	{
		if(!isset($filepath[4]))
		{
			return false;
		}

		if(!file_exists($filepath))
		{
			return false;
		}

		$listEmail=array();

		$totalEmail=0;

	    require(ROOT_PATH.'contents/plugins/emailmarketing/modules/Excel/php-excel-reader/excel_reader2.php');

	    require(ROOT_PATH.'contents/plugins/emailmarketing/modules/Excel/SpreadsheetReader_XLSX.php');

	    $Reader = new SpreadsheetReader_XLSX($filepath);

	    $data='';

	    foreach ($Reader as $Row)
	    {
	        $data.=implode("\r\n", $Row);

	    }	
	    if(preg_match_all('/([a-zA-Z0-9_\.\-]+\@\w+\.\w+)/i', $data,$matches))
		{
			$listEmail=$matches[1];
		}


		return $listEmail;

	}

	public function emailFromXLS($filepath='')
	{
		if(!isset($filepath[4]))
		{
			return false;
		}

		if(!file_exists($filepath))
		{
			return false;
		}

		$listEmail=array();

		$totalEmail=0;

		require(ROOT_PATH.'contents/plugins/emailmarketing/modules/excel_reader2.php');

		$loadData = new Spreadsheet_Excel_Reader($filepath,false,"UTF-8");

		$loadData=new Spreadsheet_Excel_Reader();
		$loadData->setUTFEncoder('iconv');
		$loadData->setOutputEncoding('UTF-8');
		$loadData->read($filepath);

		$content=$loadData->sheets[0]['cells'];	
		
		$total=count($content);

		for ($i=0; $i < $total; $i++) { 

			if(!isset($content[$i]))
			{
				continue;
			}

				$row=$content[$i];

				$totalcell=count($row);

				for ($j=0; $j < $totalcell; $j++) { 

					if(!isset($row[$j]))
					{
						continue;
					}

					$cell=$row[$j];

					if(preg_match('/([a-zA-Z0-9_\.\-]+\@\w+\.\w+)/i', $cell,$match))
					{
						$listEmail[$totalEmail]=$match[1];

						$totalEmail++;
					}					
				}
			}	


		return $listEmail;

	}


}

?>