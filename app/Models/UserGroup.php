<?php


namespace App\Models;


use App\Models\DTO\GroupData;
use CodeIgniter\Model;

/**
 * Class UserGroup
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property string $userSId
 * @property string $groupSId
 */
class UserGroup extends Model
{
    protected $table = 'user_group';
    protected $returnType = self::class;
    protected $primaryKey = 'userSId';
    protected $allowedFields = ['userSId', 'groupSId'];

    /**
     * @param string      $userSid
     * @param GroupData[] $groups
     */
    public function updateRelationsByUserSid(string $userSid, array $groups): void
    {
        $this->where('userSId', $userSid)->delete();

        $data = [];

        /** @var GroupData $group */
        foreach ($groups as $group) {
            $data[] = [
                'userSId' => $userSid,
                'groupSId' => $group->sID
            ];
        }

        $this->insertBatch($data);
    }
}