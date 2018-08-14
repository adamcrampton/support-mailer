<?php

// Front end routes.
Route::get('/', 'PageController@index');

// Admin routes.
Route::resource('admin', 'AdminController');

// CRUD routes.
Route::resource('config', 'ConfigController');
Route::resource('issue_types', 'IssueTypeController');
Route::resource('staff_members', 'StaffMemberController');
Route::resource('logs', 'SubmissionLogController');

