<?php

class Home extends BaseController
{


	public function showHome()
	{
		return View::make('home');
	}

}
