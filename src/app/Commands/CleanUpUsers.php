<?php

declare(strict_types = 1);

namespace App\Commands;

use App\Services\User\CleanUpService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Class CleanupUser
 *
 * @package App\Commands
 */
class CleanUpUsers extends BaseCommand
{
    public $group = 'app';
    public $name = 'app:cleanup-users';
    public $description = 'This command will deactivate all users that are no longer exists in the ad.';

    /** @inheritDoc */
    public function run(array $params): void
    {
        CLI::write('Starting to clean up users.');

        $service = new CleanUpService();
        try {
            $service->cleanUpUsers();
        } catch (\ReflectionException | \Exception $exception) {
            CLI::error('An unexpected Exception is occurred. Please try again later.');
            log_message('error', sprintf('An unexpected Exception occurred while clean up users. %s', $exception));
        }

        CLI::write('Done with clean up');
    }
}