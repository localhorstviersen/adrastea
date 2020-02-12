<?php


namespace App\Models;


use App\Models\DTO\UserData;
use CodeIgniter\Model;

/**
 * Class User
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property string $sId
 * @property string $username
 * @property string $firstName
 * @property string $surname
 * @property string $mail
 */
class User extends Model
{
    protected $table = 'user';
    protected $returnType = self::class;
    protected $primaryKey = 'sId';
    protected $allowedFields = ['sId', 'username', 'firstName', 'surname', 'mail'];
    protected $useTimestamps = true;

    /**
     * @var array
     */
    private $rights = [];

    /**
     * @param UserData $userData
     *
     * @return bool
     */
    public function saveOrUpdateByUserData(UserData $userData): bool
    {
        $group = new Group();
        $group->createOrUpdateGroups($userData->groups);

        $data = $userData->getDataArray();
        /** @var User $user */
        $user = $this->where('sId', $userData->sId)->first();

        try {
            if ($user instanceof self) {
                $this->update($userData->sId, $data);
            } else {
                $this->insert($data);
            }

            $userGroup = new UserGroup();
            $userGroup->updateRelationsByUserSid($userData->sId, $userData->groups);
        } catch (\ReflectionException $e) {
            return false;
        }

        return true;
    }

    /**
     * This method will get all groups of the user.
     *
     * @return array
     */
    public function getGroups(): array
    {
        $groupModel = new Group();

        return $groupModel->join('user_group', 'user_group.groupSId = group.sId')->where(
            'user_group.userSId',
            $this->sId
        )->findAll();
    }

    /**
     * This method loads all roles and rights belonging to the user into the model.
     */
    public function loadRights(): void
    {
        $roles = Roles::findByUserSid($this->sId);
        $rights = [];

        /** @var Roles $role */
        foreach ($roles as $role) {
            $rights = array_merge($rights, $role->getRights());
        }

        $rights = array_unique($rights);

        $this->rights = $rights;
    }

    /**
     * This method will check if a user has the provided right.
     *
     * @param string $right
     *
     * @return bool
     */
    public function hasRight(string $right): bool
    {
        return in_array($right, $this->rights, true);
    }
}