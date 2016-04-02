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

		// Login route
		$api->post('login', 'AuthController@authenticate');
		$api->post('register', 'AuthController@register');

		// Statistics
		$api->get('statistics/users', 'StatisticsController@users');

		// Graphics
		$api->get('graphics/members-map-norway.svg', 'GraphicsController@membersMapNorway');

		// All routes in here are protected and thus need a valid token
		// $api->group( [ 'protected' => true, 'middleware' => 'jwt.refresh' ], function ($api) {
		$api->group( [ 'middleware' => 'jwt.refresh' ], function ($api) {

			$api->get('users/me', 'AuthController@me');
			$api->get('validate_token', 'AuthController@validateToken');
			$api->get('dogs', 'DogsController@index');
			$api->post('dogs', 'DogsController@store');
			$api->get('dogs/{id}', 'DogsController@show');
			$api->delete('dogs/{id}', 'DogsController@destroy');
			$api->put('dogs/{id}', 'DogsController@update');
		});
	});
});

// Route::controller('/auth', 'App\Http\Controllers\Auth\AuthController');