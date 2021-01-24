<?php


namespace App\Models\Project;


use App\Models\Project\Ticket\Field;
use CodeIgniter\Model;

/**
 * Class Tickets
 *
 * @package App\Models\Project
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $projectId
 * @property string $userSId
 * @property string $created_at
 * @property string $updated_at
 */
class Ticket extends Model
{
    protected $table = 'project_tickets';
    protected $returnType = self::class;
    protected $allowedFields = ['projectId', 'userSid'];
    protected $useTimestamps = true;

    /**
     * This method will return the value of the given field of this ticket.
     *
     * @param  string  $identification
     *
     * @return string|null
     */
    public function getFieldValue(string $identification): ?string
    {
        $fieldModel = new Field();

        /** @var Field|null $field */
        $field = $fieldModel->where('identification', $identification)
            ->where('projectId', $this->projectId)
            ->first();

        if (!$field instanceof Field) {
            return null;
        }

        return $field->getValue($this->id);
    }
}