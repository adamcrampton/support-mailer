<?php

// Front end routes.
Route::resource('/', 'SupportRequestController');

// Admin routes.
Route::resource('admin', 'AdminController');

// CRUD routes.
Route::resource('config', 'ConfigController');
Route::resource('issue_types', 'IssueTypeController');
Route::post('/batch_update', 'IssueTypeController@batchUpdate');
Route::resource('providers', 'ProviderController');
Route::resource('staff_members', 'StaffMemberController');
Route::resource('logs', 'SubmissionLogController');
Route::resource('users', 'UserController');

// Auth Routes.
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
