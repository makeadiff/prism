<?php

class Prism extends BaseController
{


    public function showSuccess()
    {
        return View::make('success');
    }

    public function showError()
    {
        return View::make('error');
    }

    public function logout()
    {

        if(App::environment('local')) {
            return Redirect::to("http://localhost/makeadiff.in/home/makeadiff/public_html/madapp/index.php/auth/logout");
        } else {
            return Redirect::to("http://makeadiff.in/madapp/index.php/auth/logout");
        }

    }

}
