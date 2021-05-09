<?php

namespace App\Libraries\TicketFields;

use App\Models\Project\Ticket\Field as FieldModel;

/**
 * Class BoxField
 *
 * @package App\Libraries\TicketFields
 */
abstract class BoxField extends Field
{
    private array $options;

    public function __construct(FieldModel $field)
    {
        parent::__construct($field);
        $this->options = explode(';', $field->definition);
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return $this->options;
    }
}