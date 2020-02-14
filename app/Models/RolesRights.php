<?php


namespace App\Models;


use CodeIgniter\Model;

/**
 * Class RolesRights
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $roleId
 * @property string $right
 */
class RolesRights extends Model
{
    public const RIGHT_GLOBAL_ADMIN = 'admin';
    public const RIGHT_GLOBAL_ADMIN_USER = 'admin.user';
    public const RIGHT_GLOBAL_ADMIN_ROLE = 'admin.role';
    public const RIGHT_GLOBAL_ADMIN_GROUP = 'admin.group';

    protected $table = 'roles_rights';
    protected $returnType = RolesRights::class;
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
        ];
    }
}