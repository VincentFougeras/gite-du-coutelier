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


/*
 * Pages principales
 *
 */

Route::get('/', "HomeController@home");
Route::get('/getDates', 'ReservationController@updateDates'); // Ajax

// Livre d'or
Route::get('/visitors-book', 'HomeController@visitorsBook');
Route::middleware(['auth'])->group(function(){
    Route::post('/visitors-book', 'HomeController@addBook');
    Route::delete('/visitors-book/{book_id}', 'HomeController@deleteBook')->where('book_id', '[0-9]+');
});

// Partie client
Route::middleware(['auth'])->prefix('my')->group(function(){
    Route::get('reservations', 'ClientController@reservations');
    Route::get('reservation/{reservation_id}', 'ClientController@reservation')->where('reservation_id', '[0-9]+');
    Route::delete('reservation/{reservation_id}', 'ClientController@cancelReservation')->where('reservation_id', '[0-9]+');

    Route::get('informations', 'ClientController@informations');
    Route::put('informations', 'ClientController@updateInformations');
});

// Contact
Route::get('/contact', 'HomeController@contactForm');
Route::post('/contact', 'HomeController@contactSend');

// Les activités
Route::get('activites', 'SectionController@sections');

/*
 * Backoffice
 *
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function(){
    Route::get('reservations', 'AdminController@reservations');
    Route::get('reservation/{reservation_id}', 'AdminController@reservation')->where('reservation_id', '[0-9]+');

    Route::get('reservation/make', 'ReservationController@makeFake');
    Route::post('reservation/make', 'ReservationController@acceptFake');

    Route::get('section/add', 'SectionController@addForm');
    Route::post('section', 'SectionController@add');
    Route::get('section/{section_id}', 'SectionController@updateform')->where('section_id', '[0-9]+');
    Route::put('section/{section_id}', 'SectionController@update')->where('section_id', '[0-9]+');
    Route::delete('section/{section_id}', 'SectionController@delete')->where('section_id', '[0-9]+');
});


/*
 * Réservation
 *
 */

Route::group(['prefix' => 'reservation'], function(){
    Route::get('/choice', 'ReservationController@makeChoice');
    // Ajax
    Route::post('/choice/updateDates', 'ReservationController@updateDates');
    Route::post('/choice/updatePrice', 'ReservationController@updatePrice');


    Route::post('/charge', 'ReservationController@acceptReservation');

    Route::post('/logged-charge', 'ReservationController@acceptReservationLogged')
        ->middleware('auth');

    Route::get('/done/{reservation_id}', 'ReservationController@done')
            ->where('reservation_id', '[0-9]+')
            ->middleware('auth');
});


/*
 * Authentification
 *
 */

//Auth::routes();
/*  // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
 */
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');