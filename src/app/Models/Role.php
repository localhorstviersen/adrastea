<?php


namespace App\Models;


use App\Models\Roles\Rights;
use CodeIgniter\Model;

/**
 * Class Roles
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property string $name
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $returnType = Role::class;
    protected $allowedFields = ['name'];
    protected $useTimestamps = true;

    /**
     * This method finds all roles of a user by their SId. This includes the roles that are attached to the user by a group.
     *
     * @param string $userSId
     *
     * @return Role[]
     */
    public static function findByUserSid(string $userSId): array
    {
        $rolesModel = new self();

        return $rolesModel->join('group_roles', 'group_roles.roleId = roles.id')
            ->join('user_group', 'user_group.groupSId = group_roles.groupSId')
            ->where('user_group.userSId', $userSId)->findAll();
    }

    /**
     * This method will retrieve the rights of the role.
     *
     * @return array
     */
    public function getRights(): array
    {
        $result = [];
        $rights = (new Rights())->where('roleId', $this->id)->findAll();

        /** @var Rights $right */
        foreach ($rights as $right) {
            $result[] = $right->right;
        }

        return $result;
    }
}