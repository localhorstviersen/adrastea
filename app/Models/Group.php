<?php


namespace App\Models;


use App\Models\DTO\GroupData;
use CodeIgniter\Model;

/**
 * Class Group
 *
 * @package App\Models
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
}