<?php

declare(strict_types = 1);

namespace App\Services\User;

use App\Libraries\LDAP;
use App\Models\DTO\UserData;
use App\Models\User;
use CodeIgniter\CLI\CLI;
use CodeIgniter\I18n\Time;

/**
 * Class CleanUpService
 *
 * @package App\Services\User
 */
class CleanUpService
{
    /**
     * This method will iterate over all users in the database and will ask at the ad server if the user exists.
     * When a user no longer exists the user will be marked as deactivated.
     *
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function cleanUpUsers(): void
    {
        $ldap = new LDAP();
        $success = $ldap->checkCredentials(env('ldap.username'), env('ldap.password'));

        if (!$success) {
            throw new \Exception('LDAP Connection could not be initialized');
        }

        $userModel = new User();
        /** @var User[] $users */
        $users = $userModel->findAll();

        foreach ($users as $user) {
            $userData = $ldap->getUserDataBySId($user->sId);

            if (!$userData instanceof UserData && empty($user->deactivatedAt)) {
                $data = ['deactivatedAt' => Time::now()];
                $userModel->update($user->sId, $data);
                CLI::write(sprintf('User "%s" is now deactivated.', $user->username));
            }
        }
    }
}