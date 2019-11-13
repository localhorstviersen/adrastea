<?php namespace App\Controllers;

class Home extends CoreController
{
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
