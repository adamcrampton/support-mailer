<?php

// Front end routes.
Route::get('/', 'PageController@index');
Route::resource('forms', 'FormController');

// Admin routes.
Route::resource('admin', 'AdminController');

// CRUD routes.
Route::resource('config', 'ConfigController');
Route::resource('issue_types', 'IssueTypeController');
Route::resource('staff_members', 'StaffMemberController');
Route::resource('logs', 'SubmissionLogController');

