<?php
Route::get('/', 'HomeController@index');

Route::post('competitions', 'CompetitionsController@create');
Route::get('competitions/comps/{competition_id}', 'CompetitionsController@comps');

Route::get('/track', 'CompetitionsController@track')->name('bahn');
Route::get('/indoor', 'CompetitionsController@indoor')->name('halle');
Route::get('/cross', 'CompetitionsController@cross');

Route::get('/details/{competition_id}', 'CompetitionsController@details');
Route::get('/players/{team_id}', 'TeamsOldController@players');
Route::get('/table', 'TableController@index');
Route::get('/announciators/competitions_select/{competition_id}', 'AnnounciatorsController@competitions_select');
Route::get('/announciators/list_participator', 'AnnounciatorsController@listParticipator');
Route::get('/announciators/create/{competition_id?}', 'AnnounciatorsController@create');
Route::post('/announciators/store', 'AnnounciatorsController@store')->name('announciators/store');

Route::get('/records/record', 'RecordsController@index')->name('records.record');
Route::get('/records/{id}', 'RecordsController@record');
Route::get('/records/best/{sex}', 'RecordsController@best');
Route::get('/pages/{mnemonic}', 'PagesController@show');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('/', 'Admin\HomeController');
    Route::resource('/home', 'Admin\HomeController');
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('organizers', 'Admin\OrganizersController');
    Route::post('organizers_mass_destroy', ['uses' => 'Admin\OrganizersController@massDestroy', 'as' => 'organizers.mass_destroy']);
    Route::resource('participators', 'Admin\ParticipatorsController');
    Route::post('participators_mass_destroy', ['uses' => 'Admin\ParticipatorsController@massDestroy', 'as' => 'participators.mass_destroy']);
    Route::resource('games', 'Admin\GamesController');
    Route::post('games_mass_destroy', ['uses' => 'Admin\GamesController@massDestroy', 'as' => 'games.mass_destroy']);
    Route::resource('addresses', 'Admin\AddressesController');
    Route::post('addresses_mass_destroy', ['uses' => 'Admin\AddressesController@massDestroy', 'as' => 'addresses.mass_destroy']);
    Route::post('competitions/resultsets/{competition_id}', 'Admin\CompetitionController@resultsets')->name('competitions.resultsets');
    Route::post('competitions/participator/{competition_id}', 'Admin\CompetitionController@participator')->name('competitions.participator');
    Route::delete('competitions/delete_file/{upload_id}', 'Admin\CompetitionController@delete_file')->name('competitions.delete_file');
    Route::resource('competitions', 'Admin\CompetitionController');
    Route::post('competitions_mass_destroy', ['uses' => 'Admin\CompetitionController@massDestroy', 'as' => 'competitions.mass_destroy']);
    Route::resource('records', 'Admin\RecordController');
    Route::resource('pages', 'Admin\PagesController');
    Route::post('pages_mass_destroy', ['uses' => 'Admin\PagesController@massDestroy', 'as' => 'pages.mass_destroy']);
});


