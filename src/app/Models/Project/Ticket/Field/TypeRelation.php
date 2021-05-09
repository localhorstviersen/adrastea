<?php

namespace App\Models\Project\Ticket\Field;

use CodeIgniter\Model;

/**
 * Class TypeRelation
 *
 * @package App\Models\Project\Ticket\Field
 *
 * @property int $fieldId
 * @property int $typeId
 */
class TypeRelation extends Model
{
    protected $table = 'project_ticket_field_type_relation';
    protected $returnType = self::class;
    protected $allowedFields = [
        'fieldId',
        'typeId',
    ];
    protected $useTimestamps = false;
}