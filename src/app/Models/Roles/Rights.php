<?php


namespace App\Models\Roles;


use CodeIgniter\Model;

/**
 * Class Rights
 *
 * @package App\Models\Roles
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $roleId
 * @property string $right
 */
class Rights extends Model
{
    public const RIGHT_GLOBAL_ADMIN = 'admin.main';
    public const RIGHT_GLOBAL_ADMIN_USER = 'admin.user';
    public const RIGHT_GLOBAL_ADMIN_ROLE = 'admin.role';
    public const RIGHT_GLOBAL_ADMIN_GROUP = 'admin.group';
    public const RIGHT_GLOBAL_ADMIN_PROJECT_MANAGE = 'admin.project.manage';

    protected $table = 'roles_rights';
    protected $returnType = Rights::class;
    protected $allowedFields = ['roleId', 'right'];

    /**
     * This method will return all global rights.
     *
     * @return array
     */
    public static function getAllGlobalRights(): array
    {
        return [
            self::RIGHT_GLOBAL_ADMIN => lang('right.global.' . self::RIGHT_GLOBAL_ADMIN),
            self::RIGHT_GLOBAL_ADMIN_USER => lang('right.global.' . self::RIGHT_GLOBAL_ADMIN_USER),
            self::RIGHT_GLOBAL_ADMIN_ROLE => lang('right.global.' . self::RIGHT_GLOBAL_ADMIN_ROLE),
            self::RIGHT_GLOBAL_ADMIN_GROUP => lang('right.global.' . self::RIGHT_GLOBAL_ADMIN_GROUP),
            self::RIGHT_GLOBAL_ADMIN_PROJECT_MANAGE => lang('right.global.' . self::RIGHT_GLOBAL_ADMIN_PROJECT_MANAGE),
        ];
    }
}