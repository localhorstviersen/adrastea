<?php


namespace App\Models;


use App\Models\DTO\UserData;
use CodeIgniter\Model;

/**
 * Class User
 *
 * @package App\Models
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
}