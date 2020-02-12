<?php


namespace App\Models;


use CodeIgniter\Model;

/**
 * Class GroupRoles
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property string $groupSId
 * @property int    $roleId
 */
class GroupRoles extends Model
{
    protected $table = 'group_roles';
    protected $returnType = GroupRoles::class;
    protected $allowedFields = ['groupSId', 'roleId'];
}