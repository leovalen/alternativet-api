<?php
$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function ($api) {

	// Health check
	$api->get('health', function(){
		return response()->json(['status' => 'OK'], 200);
	});

	// Set our namespace for the underlying routes
	$api->group(['namespace' => 'Api\Controllers'], function ($api) {

		// Auth routes
		$api->post('login', 'UserController@authenticate');
        $api->post('verify', 'UserController@authenticate');
		$api->post('register', 'UserController@register');
        $api->post('login-with-token', 'UserController@authenticateWithLoginToken');

		// Statistics
		$api->get('statistics/users', 'StatisticsController@users');

		// Graphics
		$api->get('graphics/members-map-norway.svg', 'GraphicsController@membersMapNorway');

		// Announcements
		$api->get('announcements', 'AnnouncementController@index');
		$api->get('announcements/latest', 'AnnouncementController@latest');

        // Webhook endpoint for typeform
        $api->post('typeform', 'TypeformController@store');

        // Password reset
        $api->group( ['middleware' => 'api.throttle', 'limit' => 10, 'expires' => 5], function ($api) {
            $api->post('send-reset-password-token', 'UserController@sendResetPasswordToken');
        });

		// All routes in here are protected and thus need a valid token
		// $api->group( [ 'protected' => true, 'middleware' => 'jwt.refresh' ], function ($api) {
		$api->group( ['middleware' => 'jwt.refresh'], function ($api) {

			$api->get('users/me', 'UserController@me');
            $api->put('users/me/password', 'UserController@setPassword');
			$api->get('validate_token', 'UserController@validateToken');

            // Workplace by Facebook interface
            $api->get('workplace/account', 'WorkplaceController@status');
            $api->post('workplace/account', 'WorkplaceController@provision');
            $api->put('workplace/account/deactivate', 'WorkplaceController@deactivate');
            $api->delete('workplace/account', 'WorkplaceController@delete');

            // Dogs (example code)
			$api->get('dogs', 'DogsController@index');
			$api->post('dogs', 'DogsController@store');
			$api->get('dogs/{id}', 'DogsController@show');
			$api->delete('dogs/{id}', 'DogsController@destroy');
			$api->put('dogs/{id}', 'DogsController@update');
		});
	});
});

// Route::controller('/auth', 'App\Http\Controllers\Auth\UserController');