<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\ScheduleDates;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
  return $router->app->version();
});

$router->group(
  [
    'prefix' => 'api/v1',
  ],
  function () use ($router) {
    // Events
    $schedule = ScheduleDates::class;
    $router->post('events', 'ScheduleController@create');
    $router->get('events', [
      'uses' => 'ScheduleController@collection',
      'middleware' => ["api:{$schedule}"],
    ]);
  }
);
