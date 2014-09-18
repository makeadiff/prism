<?php



Route::filter('login_check',function()
{
    session_start();

    if(empty($_SESSION['user_id'])){

        if(App::environment('local'))
            return Redirect::to('http://localhost/makeadiff.in/home/makeadiff/public_html/madapp/index.php/auth/login/' . base64_encode(Request::url()));
        else
            return Redirect::to('http://makeadiff.in/madapp/index.php/auth/login/' . base64_encode(Request::url()));

    }


});

Route::group(array('before'=>'login_check'),function()
{
    Route::get('/', 'Home@showHome');
    Route::get('/review', 'Review@showReview');
    Route::get('/review-user','Review@showReviewUser');
    Route::post('/saveReview','Review@saveReview');
    Route::get('/success','Prism@showSuccess');
    Route::get('/error','Prism@showError');
    Route::get('/report','Report@showReport');
    Route::get('/score','Score@showScore');
    Route::get('/city-score','CityScore@showCityScore');

});


?>