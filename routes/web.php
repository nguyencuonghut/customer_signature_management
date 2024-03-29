<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Login/Logout Routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['auth']], function () {
    /*
     * Main
     */
    Route::get('/', 'ClientsController@index');
    Route::get('dashboard', 'PagesController@dashboard')->name('dashboard');

    /*
     * Users
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/data', 'UsersController@anyData')->name('users.data');
        Route::get('/taskdata/{id}', 'UsersController@taskData')->name('users.taskdata');
        Route::get('/leaddata/{id}', 'UsersController@leadData')->name('users.leaddata');
        Route::get('/clientdata/{id}', 'UsersController@clientData')->name('users.clientdata');
        Route::get('/users', 'UsersController@users')->name('users.users');
    });
    Route::resource('users', 'UsersController');

    /*
    * Roles
    */
    Route::resource('roles', 'RolesController');

    /*
     * Clients
     */
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/data', 'ClientsController@anyData')->name('clients.data');
        Route::get('/my', 'ClientsController@my')->name('clients.my');
        Route::get('/mydata', 'ClientsController@myData')->name('clients.mydata');
        Route::post('/create/cvrapi', 'ClientsController@cvrapiStart');
        Route::post('/upload/{id}', 'DocumentsController@upload');
        Route::patch('/updateassign/{id}', 'ClientsController@updateAssign');
        Route::get('/import', 'ClientsController@import')->name('clients.import');
        Route::post('doImport', 'ClientsController@doImport');
    });
    Route::resource('clients', 'ClientsController');
    Route::resource('documents', 'DocumentsController');

    /*
     * Contacts
     */
    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/data', 'ContactsController@anyData')->name('contacts.data');
        Route::get('/my', 'ContactsController@my')->name('contacts.my');
        Route::get('/mydata', 'ContactsController@myData')->name('contacts.mydata');
    });
    Route::resource('contacts', 'ContactsController');

    /*
     * Tasks
     */
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/data', 'TasksController@anyData')->name('tasks.data');
        Route::get('/my', 'TasksController@my')->name('tasks.my');
        Route::get('/mydata', 'TasksController@myData')->name('tasks.mydata');
        Route::patch('/updatestatus/{id}', 'TasksController@updateStatus');
        Route::patch('/updateassign/{id}', 'TasksController@updateAssign');
        Route::post('/updatetime/{id}', 'TasksController@updateTime');
    });
    Route::resource('tasks', 'TasksController');

    /*
     * Leads
     */
    Route::group(['prefix' => 'leads'], function () {
        Route::get('/data', 'LeadsController@anyData')->name('leads.data');
        Route::get('/my', 'LeadsController@my')->name('leads.my');
        Route::get('/mydata', 'LeadsController@myData')->name('leads.mydata');
        Route::patch('/updateassign/{id}', 'LeadsController@updateAssign');
        Route::patch('/updatestatus/{id}', 'LeadsController@updateStatus');
        Route::patch('/updatefollowup/{id}', 'LeadsController@updateFollowup')->name('leads.followup');
    });
    Route::resource('leads', 'LeadsController');
    Route::post('/comments/{type}/{id}', 'CommentController@store');
    /*
     * Settings
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/permissionsUpdate', 'SettingsController@permissionsUpdate');
        Route::patch('/overall', 'SettingsController@updateOverall');
    });

    /*
     * Departments
     */
    Route::resource('departments', 'DepartmentsController');

    /*
     * Integrations
     */
    Route::group(['prefix' => 'integrations'], function () {
        Route::get('Integration/slack', 'IntegrationsController@slack');
    });
    Route::resource('integrations', 'IntegrationsController');

    /*
     * Notifications
     */
    Route::group(['prefix' => 'notifications'], function () {
        Route::post('/markread', 'NotificationsController@markRead')->name('notification.read');
        Route::get('/markall', 'NotificationsController@markAll');
        Route::get('/{id}', 'NotificationsController@markRead');
    });

    /*
     * Invoices
     */
    Route::group(['prefix' => 'invoices'], function () {
        Route::post('/updatepayment/{id}', 'InvoicesController@updatePayment')->name('invoice.payment.date');
        Route::post('/reopenpayment/{id}', 'InvoicesController@reopenPayment')->name('invoice.payment.reopen');
        Route::post('/sentinvoice/{id}', 'InvoicesController@updateSentStatus')->name('invoice.sent');
        Route::post('/newitem/{id}', 'InvoicesController@newItem')->name('invoice.new.item');
    });
    Route::resource('invoices', 'InvoicesController');
});
