<?php

Route::get('dropzone', 'ContractController@dropzone');
Route::post('dropzone/store', ['as'=>'dropzone.store','uses'=>'ContractController@dropzoneStore']);