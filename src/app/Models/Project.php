<?php


namespace App\Models;


use App\Models\Project\Ticket\Field;
use App\Models\Project\Ticket\Status;
use App\Models\Project\Ticket\Types;
use App\Models\Project\Ticket;
use CodeIgniter\Model;

/**
 * Class Projects
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 */
class Project extends Model
{
    protected $table = 'projects';
    protected $returnType = Project::class;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;

    /**
     * This method will return all ticket types of this project.
     *
     * @return Types[]
     */
    public function getTicketTypes(): array
    {
        return (new Types())->where('projectId', $this->id)->findAll();
    }

    /**
     * This method will return all ticket types in an usable format for dropdowns.
     *
     * @return array
     */
    public function getTicketTypesForDropdown(): array
    {
        $types = [];

        foreach ($this->getTicketTypes() as $ticketType) {
            $types[$ticketType->id] = $ticketType->name;
        }

        return $types;
    }

    /**
     * This method will return all ticket status of this project.
     *
     * @return Status[]
     */
    public function getTicketStatus(): array
    {
        return (new Status())->where('projectId', $this->id)->findAll();
    }

    /**
     * This method will return all ticket status in an usable format for dropdowns.
     *
     * @return array
     */
    public function getTicketStatusForDropdown(): array
    {
        $status = [];

        foreach ($this->getTicketStatus() as $ticketStatus) {
            $status[$ticketStatus->id] = $ticketStatus->name;
        }

        return $status;
    }

    /**
     * This method will return all tickets of this project.
     *
     * @return Ticket[]
     */
    public function getTickets(): array
    {
        return (new Ticket())->where('projectId', $this->id)->findAll();
    }

    /**
     * This method will return all ticket fields of this project.
     *
     * @return Field[]
     */
    public function getFields(): array
    {
        return (new Field())->where('projectId', $this->id)->findAll();
    }
}