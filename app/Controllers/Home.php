<?php namespace App\Controllers;

/**
 * Class Home
 *
 * @package App\Controllers
 * @author  Lars Riße <me@elyday.net>
 */
class Home extends CoreController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        $this->global['title'] = 'Home';

        return view('pages/home', $this->global);
    }
}
