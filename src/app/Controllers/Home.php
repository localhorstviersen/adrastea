<?php namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

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
        $valid = $this->isRequestValid();

        if ($valid !== null) {
            return $valid;
        }

        $this->global['title'] = 'Home';

        return view('pages/home', $this->global);
    }

    /**
     * @inheritDoc
     */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        return null;
    }
}
