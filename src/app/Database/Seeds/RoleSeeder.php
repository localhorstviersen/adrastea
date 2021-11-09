<?php

declare(strict_types = 1);

namespace App\Database\Seeds;

use App\Models\Role;
use App\Models\Roles\Rights;
use CodeIgniter\Database\Seeder;
use ReflectionException;

/**
 * Class RoleSeeder
 *
 * @package App\Database\Seeds
 */
class RoleSeeder extends Seeder
{
    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function run(): void
    {
        $data = ['name' => 'Administrator'];

        $model = new Role();
        $roleId = $model->insert($data);

        $roleRights = array_keys(Rights::getAllGlobalRights());
        $roleRightsModel = new Rights();

        foreach ($roleRights as $roleRight) {
            $data = ['roleId' => $roleId, 'right' => $roleRight];
            $roleRightsModel->insert($data);
        }
    }
}