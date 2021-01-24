<?php


namespace App\Libraries\TicketFields;

use App\Models\Project\Ticket;
use App\Models\Project\Ticket\Field;
use CodeIgniter\Config\Services;

/**
 * Class TicketFieldManager
 *
 * @package App\Libraries\TicketFields
 */
class TicketFieldManager
{
    /** @var \App\Libraries\TicketFields\Field[] */
    private array $fields;
    /** @var string[] */
    private array $errors = [];

    /**
     * @param  Field[]  $fieldModels
     * @param  bool     $disabled
     */
    public function initialize(array $fieldModels, bool $disabled = false): void
    {
        foreach ($fieldModels as $fieldModel) {
            $fieldClass = FieldFactory::createFieldByModel($fieldModel, $disabled);
            if ($fieldClass !== null) {
                $this->fields[$fieldModel->identification] = $fieldClass;
            }
        }
    }

    /**
     * @param  array  $params
     */
    public function hydrate(array $params): void
    {
        foreach ($this->fields as $field) {
            $field->hydrate($params);
        }
    }

    /**
     * @param  Ticket  $ticket
     */
    public function hydrateFromTicket(Ticket $ticket): void
    {
        foreach ($this->fields as $field) {
            $field->hydrateFromTicket($ticket);
        }
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        $validationRules = [];
        $data = [];

        foreach ($this->fields as $field) {
            $validationRules[] = $field->getValidationRules();
            $data[] = [$field->getIdentification() => $field->getValue()];
        }

        $validationRules = array_merge([], ...$validationRules);
        $data = array_merge([], ...$data);

        $validation = Services::validation();

        $valid = $validation->setRules($validationRules)->run($data);

        $this->errors = $validation->getErrors();

        return $valid;
    }

    /**
     * @return \App\Libraries\TicketFields\Field[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param  string  $identification
     *
     * @return \App\Libraries\TicketFields\Field|null
     */
    public function getField(
        string $identification
    ): ?\App\Libraries\TicketFields\Field {
        if (!isset($this->fields[$identification])) {
            return null;
        }

        return $this->fields[$identification];
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param  int  $ticketId
     *
     * @throws \ReflectionException
     */
    public function storeTicketFieldDataToDatabase(int $ticketId)
    {
        foreach ($this->fields as $field) {
            $field->storeToDatabase($ticketId);
        }
    }
}