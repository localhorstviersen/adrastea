<?php


namespace App\Models\Project\Ticket;


use App\Models\Project;
use CodeIgniter\Model;
use ReflectionException;

/**
 * Class Fields
 *
 * @package App\Models\Project\Ticket
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int         $id
 * @property int         $projectId
 * @property string      $type
 * @property string      $identification
 * @property string      $name
 * @property string      $description
 * @property string|null $definition
 * @property bool        $systemField
 * @property bool        $required
 */
class Field extends Model
{
    protected $table = 'project_ticket_fields';
    protected $returnType = self::class;
    protected $allowedFields = [
        'projectId',
        'type',
        'identification',
        'name',
        'description',
        'definition',
        'systemField',
        'required',
    ];
    protected $useTimestamps = true;

    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_TYPE = 'type';
    public const TYPE_STATUS = 'status';
    public const TYPE_USER = 'user';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_RADIO_BOX = 'radioBox';
    public const TYPE_CHECK_BOX = 'checkBox';
    public const TYPE_PREDEFINED_LINK = 'predefinedLink';

    /** @var array */
    public static array $systemFields = [
        [
            'identification' => 'title',
            'name' => 'Titel',
            'type' => self::TYPE_TEXT,
            'description' => 'Titel des Tickets',
        ],
        [
            'identification' => 'assign',
            'name' => 'Zugewiesener Benutzer',
            'type' => self::TYPE_USER,
            'description' => 'Zugewiesener Benutzer',
        ],
        [
            'identification' => 'reporter',
            'name' => 'Melder',
            'type' => self::TYPE_USER,
            'description' => 'Wer hat das Ticket gemeldet?',
        ],
        [
            'identification' => 'type',
            'name' => 'Ticket-Typ',
            'type' => self::TYPE_TYPE,
            'description' => 'Ticket-Typ',
        ],
        [
            'identification' => 'status',
            'name' => 'Ticket-Status',
            'type' => self::TYPE_STATUS,
            'description' => 'Status des Tickets',
        ],
        [
            'identification' => 'description',
            'name' => 'Beschreibung',
            'type' => self::TYPE_TEXTAREA,
            'description' => 'Die Beschreibung des Tickets',
        ],
    ];

    /**
     * This method will return all field types which can have input in the
     * definition column.
     *
     * @return string[]
     */
    public static function fieldTypesWithDefinition(): array
    {
        return [
            self::TYPE_CHECK_BOX,
            self::TYPE_RADIO_BOX,
            self::TYPE_PREDEFINED_LINK,
        ];
    }

    /**
     * This method will return all field types which have a select field (like check box).
     *
     * @return string[]
     */
    public static function fieldSelectTypes(): array
    {
        return [
            self::TYPE_CHECK_BOX,
            self::TYPE_RADIO_BOX,
        ];
    }

    /**
     * This method will find a field by its identification name and the project id.
     *
     * @param int    $projectId
     * @param string $identification
     *
     * @return Field|null
     */
    public static function getFieldByProjectIdAndIdentification(
        int $projectId,
        string $identification
    ): ?Field {
        $model = new self();
        $field = $model->where('projectId', $projectId)
            ->where('identification', $identification)
            ->find();

        return !empty($field) && $field[0] instanceof self ? $field[0] : null;
    }

    /**
     * This method will return all possible types with its translation text.
     *
     * @return array
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_TEXT => lang('project.ticketFields.type.text'),
            self::TYPE_NUMBER => lang('project.ticketFields.type.number'),
            self::TYPE_TYPE => lang('project.ticketFields.type.type'),
            self::TYPE_STATUS => lang('project.ticketFields.type.status'),
            self::TYPE_USER => lang('project.ticketFields.type.user'),
            self::TYPE_TEXTAREA => lang('project.ticketFields.type.textArea'),
            self::TYPE_RADIO_BOX => lang('project.ticketFields.type.radioBox'),
            self::TYPE_CHECK_BOX => lang('project.ticketFields.type.checkBox'),
            self::TYPE_PREDEFINED_LINK => lang('project.ticketFields.type.predefinedLink'),
        ];
    }

    /**
     * This method will return all possible types for field creation with its translated text.
     *
     * @return array
     */
    public static function getTypesForFieldCreation(): array
    {
        $types = self::getTypes();
        unset($types[self::TYPE_TYPE], $types[self::TYPE_STATUS]);

        return $types;
    }

    /**
     * This method will return true if the ticket field is created from the system. If it is created from the system
     * it is not deletable.
     *
     * @return bool
     */
    public function isSystemField(): bool
    {
        return $this->systemField === '1';
    }

    /**
     * This method will return true if the ticket field is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required === '1';
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return (new Project())->find($this->projectId);
    }

    /**
     * This method will return all type relations models.
     *
     * @return Project\Ticket\Field\TypeRelation[]
     */
    public function getTypeRelations(): array
    {
        return (new Project\Ticket\Field\TypeRelation())->where('fieldId', $this->id)->findAll();
    }

    /**
     * This method will return all type entries where this field is assigned to.
     *
     * @return Types[]
     */
    public function getAssignedTypes(): array
    {
        $typeIds = $this->getAssignedTypeIds();

        if (empty($typeIds)) {
            return [];
        }

        return (new Types())->whereIn('id', $typeIds)->findAll();
    }

    /**
     * This method will return all type ids where this field is assigned to.
     *
     * @return int[]
     */
    public function getAssignedTypeIds(): array
    {
        $typeRelations = $this->getTypeRelations();

        $typeIds = [];
        foreach ($typeRelations as $typeRelation) {
            $typeIds[] = $typeRelation->typeId;
        }

        return $typeIds;
    }

    /**
     * This method will remove all type relations for this field.
     */
    public function clearTypeRelations(): void
    {
        (new Project\Ticket\Field\TypeRelation())->where('fieldId', $this->id)->delete();
    }

    /**
     * @param int[] $typeIds
     *
     * @throws ReflectionException
     */
    public function storeTypeRelations(array $typeIds): void
    {
        $typeRelationModel = new Project\Ticket\Field\TypeRelation();
        foreach ($typeIds as $typeId) {
            $typeRelationModel->insert(['fieldId' => $this->id, 'typeId' => $typeId]);
        }
    }

    /**
     * @param int $ticketId
     *
     * @return string|null
     */
    public function getValue(int $ticketId): ?string
    {
        /** @var Project\Ticket\Field\Value|null $valueModel */
        $valueModel = (new Project\Ticket\Field\Value())
            ->where('projectId', $this->projectId)
            ->where('ticketId', $ticketId)
            ->where('fieldId', $this->id)
            ->first();

        if (!$valueModel instanceof Project\Ticket\Field\Value) {
            return null;
        }

        return $valueModel->value;
    }

    /**
     * @param int         $ticketId
     * @param string|null $value
     *
     * @throws ReflectionException
     */
    public function setValue(int $ticketId, ?string $value): void
    {
        $model = new Project\Ticket\Field\Value();
        /** @var Project\Ticket\Field\Value|null $valueFind */
        $valueFind = (new Project\Ticket\Field\Value())
            ->where('projectId', $this->projectId)
            ->where('ticketId', $ticketId)
            ->where('fieldId', $this->id)
            ->first();

        if ($valueFind instanceof Project\Ticket\Field\Value) {
            $model->update($valueFind->id, ['value' => $value]);

            return;
        }

        $model->insert(
            [
                'projectId' => $this->projectId,
                'ticketId' => $ticketId,
                'fieldId' => $this->id,
                'value' => $value,
            ]
        );
    }
}