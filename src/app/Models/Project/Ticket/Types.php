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
}