<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});

Route::post('login', 'APILoginController@login');

Route::post('register', 'APIRegisterController@register');

Route::post('sendOTP', 'APIForgotPasswordController@sendOTP');

Route::post('reSendOTP', 'APIForgotPasswordController@reSendOTP');

Route::post('verifyOTP', 'APIForgotPasswordController@verifyOTP');

Route::post('socialLogin', 'APISocialLoginController@socialLogin');

Route::post('createEvents', 'APIEventsController@createEvents');

Route::post('showEvent', 'APIEventsController@showEvent');

Route::post('updateEvents', 'APIEventsController@updateEvents');

Route::post('listCreatedEvents','APIEventsController@listCreatedEvents');

Route::post('listParticipatingEvents','APIEventsController@listParticipatingEvents');

Route::post('listUpcomingParticipatingEvents','APIEventsController@listUpcomingParticipatingEvents');

Route::post('listPastParticipatingEvents','APIEventsController@listPastParticipatingEvents');

Route::post('deleteMyEvent','APIEventsController@deleteMyEvent');

Route::post('createEventType','APIEventTypeController@createEventType');

Route::post('listEventType','APIEventTypeController@listEventType');

Route::post('updateEventType','APIEventTypeController@updateEventType');

Route::post('deleteEventType','APIEventTypeController@deleteEventType');

Route::post('createEventParticipantsRole','APIEventParticipantsRoleController@createEventParticipantsRole');

Route::post('updateEventParticipantsRole','APIEventParticipantsRoleController@updateEventParticipantsRole');

Route::post('listEventParticipantsRole','APIEventParticipantsRoleController@listEventParticipantsRole');

Route::post('deleteEventParticipantsRole','APIEventParticipantsRoleController@deleteEventParticipantsRole');

Route::middleware('jwt.auth')->group(function(){
    
   // Route::post('createEvents', 'APIEventsController@createEvents');

   // Route::post('showEvent', 'APIEventsController@showEvent');

   // Route::post('updateEvents', 'APIEventsController@updateEvents');
});
