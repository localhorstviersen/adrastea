<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;
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
abstract class CoreController extends Controller
{
    public const SESSION_LOGGED_IN = 'isLoggedIn';
    public const SESSION_USER_SID = 'userSId';

    protected $helpers = ['form'];

    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * @var array $global
     */
    protected array $global = [];

    /**
     * @var Session $session
     */
    protected Session $session;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->session = Services::session();

        if ($this->isLoggedIn()) {
            $this->global['user'] = $this->user;
            $this->global['fullName'] = $this->user->getFullName();
        }

        $this->global['successForm'] = $this->session->getFlashdata(
            'successForm'
        );
        $this->global['errorForm'] = $this->session->getFlashdata('errorForm');

        $this->setNavigationGlobals();
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
            if (!$this->user instanceof User
                || ($this->user instanceof User
                    && $this->user->sId !== $userSId)
            ) {
                $userModel = new User();
                $userModel = $userModel->where(
                    'sId',
                    $this->session->get(
                        self::SESSION_USER_SID
                    )
                );

                if ($userModel->countAllResults(false) !== 1) {
                    $this->session->destroy();
                    $this->session->setFlashdata(
                        'errorForm',
                        ['Du wurdest automatisch ausgeloggt.']
                    );

                    return false;
                }

                $this->user = $userModel->first();
                $this->user->loadRights();
            }

            return true;
        }

        return false;
    }

    /**
     * This method check if the incoming request a post request.
     *
     * @return bool
     */
    protected function isPost(): bool
    {
        return $this->request->getMethod() === 'post';
    }

    /**
     * This method will check if the incoming Request is valid.
     *
     * @param  string|null  $modelId
     *
     * @return RedirectResponse|null
     */
    abstract protected function isRequestValid(
        ?string $modelId = null
    ): ?RedirectResponse;

    private function setNavigationGlobals(): void
    {
        $uri = Services::uri();
        $this->global['segments'] = $segments = $uri->getSegments();

        if(count($segments) === 2) {
            $this->global['inProjectManagement'] = $segments[0] === 'admin' && $segments[1] === 'project';
            $this->global['inUserManagement'] = $segments[0] === 'admin' && in_array($segments[1], ['group', 'user', 'role']);
        } else {
            $this->global['inProjectManagement'] = false;
            $this->global['inUserManagement'] = false;
        }
    }
}