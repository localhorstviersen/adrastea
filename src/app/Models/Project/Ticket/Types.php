<?php

namespace App\Models\Project\Ticket;

use CodeIgniter\Model;

/**
 * Class Types
 *
 * @package App\Models\Project\Ticket
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $projectId
 * @property string $name
 */
class Types extends Model
{
    protected $table = 'project_ticket_types';
    protected $returnType = self::class;
    protected $allowedFields = ['projectId', 'name'];

    public static array $defaultTypes = ['Issue', 'Story', 'Bug'];

    /**
     * This method will return an array with all types with their database id as key. As first entry there is an item
     * with null as key.
     *
     * @return string[]
     */
    public static function getTypes(): array
    {
        $typesArray = [];
        $types = (new Types())->findAll();

        /** @var self $type */
        foreach ($types as $type) {
            $typesArray[$type->id] = $type->name;
        }

        return $typesArray;
    }
}