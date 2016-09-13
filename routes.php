<?php

// Load 'before_system_start' plugins
System::before_system_start();

// Load sytem settings

Route::get('^\/?api', 'application/api@index');

Route::get('^\/?npanel', 'application/npanel@index');

Route::get('', 'application/frontend@index');

