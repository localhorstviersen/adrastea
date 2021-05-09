<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Logout
 * @package App\Controllers
 */
class Logout extends CoreController
{
    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $this->session->destroy();
        return redirect()->to(site_url('login'));
    }

    /** @inheritDoc */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        return null;
    }
}