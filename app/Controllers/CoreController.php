<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Config\Services;
use Psr\Log\LoggerInterface;

/**
 * Class CoreController
 *
 * @package App\Controllers
 * @author  Lars Riße <me@elyday.net>
 */
class CoreController extends Controller
{
    public const SESSION_LOGGED_IN = 'isLoggedIn';
    public const SESSION_USER_SID = 'userSId';

    /**
     * @var User|null
     */
    protected $user;

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

        if ($this->isLoggedIn()) {
            $this->global['fullName'] = $this->user->firstName . ' ' . $this->user->surname;
        }

        $this->global['errorForm'] = $this->session->getFlashdata('errorForm');
    }

    /**
     * This method check if the current user is logged in.
     *
     * @return bool
     */
    protected function isLoggedIn(): bool
    {
        $isLoggedIn = $this->session->get(self::SESSION_LOGGED_IN);
        $userSId = $this->session->get(self::SESSION_USER_SID);

        if (isset($isLoggedIn, $userSId) && $isLoggedIn && !empty($userSId)) {
            if (!$this->user instanceof User || ($this->user instanceof User && $this->user->sId !== $userSId)) {
                $userModel = new User();
                $userModel = $userModel->where('sId', $this->session->get(self::SESSION_USER_SID));

                if ($userModel->countAllResults(false) !== 1) {
                    $this->session->destroy();
                    $this->session->setFlashdata('errorForm', ['Du wurdest automatisch ausgeloggt.']);
                    return false;
                }

                $this->user = $userModel->first();
            }
            return true;
        }

        return false;
    }
}