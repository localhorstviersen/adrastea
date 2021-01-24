<?php


namespace App\Models\Project\Ticket;


use CodeIgniter\Model;

/**
 * Class Status
 *
 * @package App\Models\Project\Ticket
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $projectId
 * @property string $name
 */
class Status extends Model
{
    protected $table = 'project_ticket_status';
    protected $returnType = self::class;
    protected $allowedFields = ['projectId', 'name'];

    public static array $defaultStatus = ['Offen', 'Geschlossen', 'In Bearbeitung'];
}