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
 * @property string      $sId
 * @property string      $username
 * @property string      $firstName
 * @property string      $surname
 * @property string      $mail
 * @property string      $created_at
 * @property string|null $deactivatedAt
 */
class User extends Model
{
    protected $table = 'user';
    protected $returnType = self::class;
    protected $primaryKey = 'sId';
    protected $allowedFields = [
        'sId',
        'username',
        'firstName',
        'surname',
        'mail',
        'deactivatedAt',
    ];
    protected $useTimestamps = true;

    /**
     * @var array
     */
    private $rights = [];

    public static function getFullNameBySId(string $sId): ?string
    {
        /** @var self|null $model */
        $model = (new User())->find($sId);

        if (!$model instanceof self) {
            return null;
        }

        return $model->getFullName();
    }

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
            $userGroup->updateRelationsByUserSid(
                $userData->sId,
                $userData->groups
            );
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

        return $groupModel->join(
            'user_group',
            'user_group.groupSId = group.sId'
        )->where(
            'user_group.userSId',
            $this->sId
        )->findAll();
    }

    /**
     * This method loads all roles and rights belonging to the user into the model.
     */
    public function loadRights(): void
    {
        $roles = Role::findByUserSid($this->sId);
        $rights = [];

        foreach ($roles as $role) {
            $rights[] = $role->getRights();
        }

        $rights = array_merge([], ...$rights);

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

    /**
     * This method will check if a user has the provided rights.
     *
     * @param string ...$rights
     *
     * @return bool
     */
    public function hasOneRight(string ...$rights): bool
    {
        foreach ($rights as $right) {
            if ($this->hasRight($right)) {
                return true;
            }
        }

        return false;
    }

    /**
     * This method will get all projects where the given user has a view permission.
     *
     * @return array
     */
    public function getProjects(): array
    {
        $roles = Role::findByUserSid($this->sId);
        $roleIds = [];

        foreach ($roles as $role) {
            $roleIds[] = $role->id;
        }

        if (empty($roleIds)) {
            return [];
        }

        $projectModel = new Project();
        $builder = $projectModel->select('projects.*')->join(
            'project_role_rights',
            'project_role_rights.projectId = projects.id'
        )->where(
            'project_role_rights.right',
            ProjectRoleRights::RIGHT_PROJECT_VIEW
        )->whereIn('project_role_rights.roleId', $roleIds);

        return $builder->findAll();
    }

    /**
     * This method check if the user has the provided right on the provided project.
     *
     * @param Project $project
     * @param string  $right
     *
     * @return bool
     */
    public function hasProjectRight(Project $project, string $right): bool
    {
        $roles = Role::findByUserSid($this->sId);
        $roleIds = [];

        foreach ($roles as $role) {
            $roleIds[] = $role->id;
        }

        $rights = $project->select('projects.*')->join(
            'project_role_rights',
            'project_role_rights.projectId = projects.id'
        )->where(
            'project_role_rights.right',
            $right
        )->whereIn('project_role_rights.roleId', $roleIds)->where(
            'projects.id',
            $project->id
        )->findAll();

        return count($rights) === 1;
    }

    /**
     * This method will return the firstname and surname of this user as one string.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->surname);
    }
}