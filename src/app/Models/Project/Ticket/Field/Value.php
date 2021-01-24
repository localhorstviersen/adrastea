<?php

namespace App\Models\Project\Ticket\Field;

use CodeIgniter\Model;

/**
 * Class Value
 *
 * @package App\Models\Project\Ticket\Field
 *
 * @property int    $id
 * @property int    $projectId
 * @property int    $fieldId
 * @property string $value
 */
class Value extends Model
{
    protected $table = 'project_ticket_field_values';
    protected $returnType = self::class;
    protected $allowedFields = ['projectId', 'ticketId', 'fieldId', 'value'];
    protected $useTimestamps = true;
}