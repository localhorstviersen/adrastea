<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Config\Services;
use Psr\Log\LoggerInterface;

class CoreController extends Controller
{
    /**
     * @var array $global
     */
    protected $global = [];

    /**
     * @var Session $session
     */
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = Services::session();

        $this->global['errorForm'] = $this->session->getFlashdata('errorForm');
    }

    /**
     * This method check if the current user is logged in.
     *
     * @return bool
     */
    protected function isLoggedIn(): bool
    {
        $isLoggedIn = session('isLoggedIn');

        return isset($isLoggedIn) && $isLoggedIn;
    }
}