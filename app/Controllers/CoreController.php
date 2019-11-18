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

class CoreController extends Controller
{
    /**
     * @var array $global
     */
    protected $global = [];

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