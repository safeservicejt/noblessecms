<?php

Plugins::install('install_firemanga');

Plugins::uninstall('uninstall_firemanga');

function install_firemanga()
{

	$installPath=dirname(__FILE__).'/install/';

	$dbFile=$installPath.'db.sql';

	if(file_exists($dbFile))
	{
		Database::import($dbFile);
	}

	File::copy($installPath.'Manga.php',ROOT_PATH.'includes/Manga.php');

	File::copy($installPath.'MangaAuthors.php',ROOT_PATH.'includes/MangaAuthors.php');

	File::copy($installPath.'MangaCategories.php',ROOT_PATH.'includes/MangaCategories.php');

	File::copy($installPath.'MangaChapters.php',ROOT_PATH.'includes/MangaChapters.php');

	File::copy($installPath.'MangaTags.php',ROOT_PATH.'includes/MangaTags.php');

	Plugins::add('admin_left_menu',array(
		'text'=>'FireManga',
		'filename'=>'load.php',
		'child_menu'=>array(
						0=>array(
						'text'=>'Manga List',
						'filename'=>'controller/controlManga.php'
						),
						1=>array(
						'text'=>'Chapter List',
						'filename'=>'controller/controlChapter.php'
						),
						2=>array(
						'text'=>'Auto Leech',
						'filename'=>'controller/controlLeech.php'
						)
		)
		));



}

function uninstall_firemanga()
{
	Database::query('drop table chapter_list');

	Database::query('drop table manga_authors');

	Database::query('drop table manga_categories');

	Database::query('drop table manga_list');	
	
	Database::query('drop table manga_tags');	

	if(file_exists(ROOT_PATH.'includes/Manga.php'))
	{
		unlink(ROOT_PATH.'includes/Manga.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaAuthors.php'))
	{
		unlink(ROOT_PATH.'includes/MangaAuthors.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaCategories.php'))
	{
		unlink(ROOT_PATH.'includes/MangaCategories.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaChapters.php'))
	{
		unlink(ROOT_PATH.'includes/MangaChapters.php');
	}

	if(file_exists(ROOT_PATH.'includes/MangaTags.php'))
	{
		unlink(ROOT_PATH.'includes/MangaTags.php');
	}

}

?>