<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'LoginWebController@index');//for login page
Route::post('/login-register', 'LoginWebController@loginOrRegister');//for general login
Route::post('/register-user', 'LoginWebController@registerUser');//for first time login
Route::get('/confirm-password', 'LoginWebController@displayConfirmPasswordPage');//confirm psd for first time login
Route::post('/verify-otp', 'LoginWebController@verifyOtp');//for forgot psd verify otp
Route::get('/resend-otp', 'LoginWebController@resendOtp');//resend otp in forgot psd

Route::get('/new-password', 'LoginWebController@displayNewPassword');//to display new psd page

Route::get('/home', 'HomeController@index');

Route::get('/login/{provider}', 'SocialLoginWebController@redirectToServiceProvider');
Route::get('/login/{provider}/callback', 'SocialLoginWebController@handleProviderServiceCallback');
Route::get('/slack', 'SocialLoginWebController@redirectToSlackProvider');
Route::get('/slack/auth/callback', 'SocialLoginWebController@handleProviderSlackCallback');


Route::get('/forget-password', 'LoginWebController@displayForgetPassword');//to display forgot psd page
Route::post('/forget-password', 'LoginWebController@sendOtp');//to send otp
Route::post('/forget-password-process', 'LoginWebController@sendOtp');


Route::get('/up-events', 'EventController@eventsList');//to list upcomming and past events in homepage
Route::get('/create-events', 'EventController@displayCreateEventsPage');//to display create events page
Route::post('/add-msg', 'EventController@createEvent');//to create event
Route::post('/select-card', 'EventController@selectCardEvent');//to create event with card and date

Route::get('/write-msg', 'EventController@displayAddMessagePage');//to display addmessage page

Route::get('/invite-friends', 'EventController@displayAddFriendsPage');//to display addfriends page
Route::post('/add-invite-people', 'EventController@addInvitePeopleToSendInvitation');//to send invitation to people from addfriends page
Route::post('/send-invitation', 'EventController@sendInvitation');//to send invitation

Route::get('/delete_event', 'EventController@deleteEvent');//to delete events in homepage

Route::get('/view-msg', 'EventController@displayViewEventPage');//to display edit messagepage
Route::post('/create-msg', 'EventController@createMessage');//to create message to card
Route::get('/show-card', 'EventController@displayCreatedCardPage');//to display edit messagepage

Route::get('/guestcard', 'EventController@guestShowCard');//to display card to guest

Route::get('/edit-event', 'EventController@displayEditEventPage');//to display edit messagepage
Route::post('/update-event', 'EventController@updateEvent');//to update event in card

Route::post('/upload-card', 'EventController@uploadCard');//to upload card


Route::get('/profile', 'ProfileController@primaryDetailsPage');//to display primarydetails in profilepage
Route::post('/update-profile', 'ProfileController@updateProfile');//to update userprofile in profilepage
Route::get('/connect-social', 'ProfileController@displayConnectSocialMediaPage');//to display socialconnect in profilepage
Route::get('/significant-event', 'ProfileController@significantEventPage');//to display significantevent profilepage
Route::post('/add-significant-event', 'ProfileController@addSignificantEvent');//to add signf events in profilepage
Route::get('/show-significant', 'ProfileController@showSignificantEvent');//to show signf events in profilepage
Route::post('/update_signf_event', 'ProfileController@updateSignificantEvent');//to update signf events in profilepage
Route::get('/delete_signf_event', 'ProfileController@deleteSignificantEvent');//to delete signf events in profilepage
Route::get('/change_password', 'ProfileController@changePasswordPage');//to display changepassword in profilepage
Route::post('/change-password', 'ProfileController@createNewPassword');//to change psd in profile page



/*for add friends*/
Route::get('/connect/{social}/media', 'SocialLoginWebController@connectSocialMedia');
Route::get('/connect/{social}/callback', 'SocialLoginWebController@connectSocialMediaCallback');
Route::get('/connect/slack/get-friends', 'SocialLoginWebController@connectSlackFriends');
Route::get('/get-slack-friends', 'EventController@getSlackFriends');
Route::get('/get-twitter-friends', 'EventController@getTwitterFriendList');



Route::get('/logout', 'LoginWebController@logout');//for logout


/*extra*/
Route::get('newpasswordlogin', function()
{
    return view('newpasswordlogin');
});
Route::get('/add-people' ,'EventController@addPeople' );//to add people in create events page
//Route::post('/edit-event', 'EventController@editEvents');//to edit event
/*extra*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
