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

Route::post('registerUser', 'APILoginController@registerUser');

Route::post('register', 'APIRegisterController@register');

Route::post('sendOTP', 'APIForgotPasswordController@sendOTP');

Route::post('reSendOTP', 'APIForgotPasswordController@reSendOTP');

Route::post('verifyOTP', 'APIForgotPasswordController@verifyOTP');

Route::post('socialLogin', 'APISocialLoginController@socialLogin');

Route::post('showSelectedCard','APICardsController@showSelectedCard');

Route::middleware('jwt.auth')->group(function(){
    
   // Route::post('createEvents', 'APIEventsController@createEvents');

   //Route::post('showEvent', 'APIEventsController@showEvent');

   // Route::post('updateEvents', 'APIEventsController@updateEvents');
});

 Route::group(['middleware' => ['jwt.verify']], function() {
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

    Route::post('createCardsCategory','APICardsCategoryController@createCardsCategory');

    Route::post('listCardsCategory','APICardsCategoryController@listCardsCategory');

    Route::post('updateCardsCategory','APICardsCategoryController@updateCardsCategory');

    Route::post('deleteCardsCategory','APICardsCategoryController@deleteCardsCategory');

    Route::post('uploadCards','APICardsController@uploadCards');

    Route::post('listAllCards','APICardsController@listAllCards');

    Route::post('selectCard','APICardsController@selectCard');

    

    Route::post('createMessage','APICardsController@createMessage');

    Route::post('deleteCardMessages','APICardsController@deleteCardMessages');

    Route::post('deleteMyMessage','APICardsController@deleteMyMessage');

    Route::post('showUserProfile','APIUserProfileController@showUserProfile');

    Route::post('updateUserProfile','APIUserProfileController@updateUserProfile');

    Route::post('showConnectedSocialMedia','APIUserProfileController@showConnectedSocialMedia');

    Route::post('addSocialMediaProfile','APIUserProfileController@addSocialMediaProfile');

    Route::post('showNewNotifications','APIUserProfileController@showNewNotifications');

    Route::post('showAllNotifications','APIUserProfileController@showAllNotifications');

    Route::post('changePassword','APIUserProfileController@changePassword');

    Route::post('inviteToEvent','APIEventInvitationController@inviteToEvent');

    Route::post('showEventParticipants','APIEventParticipantsController@showEventParticipants');

    Route::post('removeEventParticipants','APIEventParticipantsController@removeEventParticipants');

    Route::post('createSignificantEvent','APISignificantEventsController@createSignificantEvent');

    Route::post('showSignificantEvent','APISignificantEventsController@showSignificantEvent');

    Route::post('updateSignificantEvent','APISignificantEventsController@updateSignificantEvent');

    Route::post('listSignificantEvents','APISignificantEventsController@listSignificantEvents');

    Route::post('deleteSignificantEvents','APISignificantEventsController@deleteSignificantEvents');

    Route::post('listSignificantEventTypes','APISignificantEventsController@listSignificantEventTypes');

    Route::post('listUserRelationships','APISignificantEventsController@listUserRelationships');

    Route::post('sendCardViaEmail','APIsendCardController@sendCardViaEmail');
});

