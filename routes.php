<?php

Database::connect();

GlobalCMS::start();

// echo Multidb::renderDb('sdfdf');
// die();




Route::get('admincp', 'admincp');

Route::get('usercp', 'usercp');

Route::get('api', 'api');

Route::get('cronjob', 'cronjob');

// Route::get('', 'frontend');

DBCache::enable();

Route::pattern('all', '.*?');
Route::get('{all}', 'frontend');



?>