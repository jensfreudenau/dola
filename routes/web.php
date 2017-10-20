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
Route::get('teams/competitions_select/{competition_id}', 'TeamsController@competitions_select');
Route::get('teams/list_participator/{participator_team_id}', 'TeamsController@listParticipator');
Route::get('/teams/create/{competition_id?}', 'TeamsController@create');
Route::post('teams/store', 'TeamsController@store')->name('teams/store');


#Route::resource('teams', 'TeamsController');
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

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('teams', 'Admin\TeamsController');
    Route::post('teams_mass_destroy', ['uses' => 'Admin\TeamsController@massDestroy', 'as' => 'teams.mass_destroy']);
    Route::resource('participators', 'Admin\ParticipatorsController');
    Route::post('participators_mass_destroy', ['uses' => 'Admin\ParticipatorsController@massDestroy', 'as' => 'participators.mass_destroy']);
    Route::resource('games', 'Admin\GamesController');
    Route::post('games_mass_destroy', ['uses' => 'Admin\GamesController@massDestroy', 'as' => 'games.mass_destroy']);
    Route::resource('addresses', 'Admin\AddressesController');
    Route::post('addresses_mass_destroy', ['uses' => 'Admin\AddressesController@massDestroy', 'as' => 'addresses.mass_destroy']);
    Route::resource('competitions', 'Admin\CompetitionController');
    Route::post('competitions_mass_destroy', ['uses' => 'Admin\CompetitionController@massDestroy', 'as' => 'competitions.mass_destroy']);

});
