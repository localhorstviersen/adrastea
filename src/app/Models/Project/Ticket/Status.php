<?php


namespace App\Models\Project\Ticket;


use App\Models\Project\Ticket;
use CodeIgniter\Model;

/**
 * Class Status
 *
 * @package App\Models\Project\Ticket
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int $id
 * @property int $projectId
 * @property string $name
 * @property int $priority
 */
class Status extends Model
{
    protected $table = 'project_ticket_status';
    protected $returnType = self::class;
    protected $allowedFields = ['projectId', 'name', 'priority'];

    public static array $defaultStatus = [
        [
            'name' => 'Offen',
            'priority' => 1
        ],
        [
            'name' => 'In Bearbeitung',
            'priority' => 2
        ],
        [
            'name' => 'Geschlossen',
            'priority' => 3
        ]
    ];

    /**
     * @return Ticket[]
     */
    public function getTickets(): array
    {
        $model = new Ticket();
        $model->select('project_tickets.*');
        $model->join('project_ticket_field_values', 'project_ticket_field_values.ticketId = project_tickets.id');
        $model->join('project_ticket_fields', 'project_ticket_fields.id = project_ticket_field_values.fieldId');
        $model->where('project_ticket_fields.identification', 'status');
        $model->where('project_ticket_field_values.value', $this->id);
        $model->orderBy('project_tickets.id');
        return $model->findAll();
    }
}