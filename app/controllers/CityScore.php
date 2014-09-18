<?php

class CityScore extends BaseController
{


    public function showCityScore()
    {
        if(!User::checkIfCTL($_SESSION['user_id']))
            return Redirect::to('error')->with('message',"Can be accessed only by the City Team Lead");
        else{
            $city_id = User::getCity($_SESSION['user_id']);
            $users = User::getCityUsers($city_id);
            return View::make('city-score')->with('users',$users);
        }
    }



}
