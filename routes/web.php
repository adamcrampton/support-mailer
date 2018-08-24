<?php

// Front end routes.
Route::resource('/', 'SupportRequestController');

// Admin routes.
Route::resource('admin', 'AdminController');

// CRUD routes.
Route::resource('config', 'ConfigController');
Route::resource('issue_types', 'IssueTypeController');
Route::get('issue_types_restore', 'IssueTypeController@indexRestore');
Route::post('/issue_type_batch_update', 'IssueTypeController@batchUpdate');
Route::resource('providers', 'ProviderController');
Route::post('/provider_batch_update', 'ProviderController@batchUpdate');
Route::resource('staff_members', 'StaffMemberController');
Route::post('/staff_member_batch_update', 'StaffMemberController@batchUpdate');
Route::resource('users', 'UserController');
Route::post('/batch_update', 'UserController@batchUpdate');
Route::resource('logs', 'SubmissionLogController');
Route::resource('permissions', 'PermissionController');

// Auth Routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
