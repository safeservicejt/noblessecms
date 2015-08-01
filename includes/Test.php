<?php

/*
	$users=new Test;

	$users->addField('dsdsd',array(
		'type'=>'int',
		'length'=>10,
		'default'=>0,
		'null'=>'yes'
		));
*/
class Test extends Table
{
	public $table='users';

	public $id='userid';

	public $fields='userid,groupid,username,firstname,lastname,image,email,password,userdata,ip,verify_code,parentid,date_added,forgot_code,forgot_date';

	public function __construct()
	{
		

	}

}
?>