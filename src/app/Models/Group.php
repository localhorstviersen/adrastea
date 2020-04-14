<?php


namespace App\Models;


use App\Models\DTO\GroupData;
use CodeIgniter\Model;

/**
 * Class Group
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property string $sId
 * @property string $name
 */
class Group extends Model
{
    protected $table = 'group';
    protected $returnType = Group::class;
    protected $primaryKey = 'sId';
    protected $allowedFields = ['sId', 'name'];
    protected $useTimestamps = true;

    public function createOrUpdateGroups(array $groups): void
    {
        /** @var GroupData $group */
        foreach ($groups as $group) {
            /** @var Group $groupResult */
            $groupResult = $this->where('sId', $group->sID)->first();

            if ($groupResult instanceof self) {
                $this->update(
                    $group->sID,
                    ['name' => $group->name]
                );
            } else {
                $this->insert(
                    [
                        'sId' => $group->sID,
                        'name' => $group->name
                    ]
                );
            }
        }
    }

    /**
     * This method will retrieve all groups belong to an user.
     *
     * @param string $userSId
     *
     * @return Group[]
     */
    public function getGroupsByUserSId(string $userSId): array
    {
        return $this->join('user_group', 'user_group.groupSId = group.sId')
            ->where('user_group.userSId', $this->sId)
            ->findAll();
    }
}