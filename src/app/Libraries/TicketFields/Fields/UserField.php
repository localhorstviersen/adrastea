<?php

namespace App\Libraries\TicketFields\Fields;

use App\Controllers\CoreController;
use App\Libraries\TicketFields\Field;
use App\Models\Project\Ticket\Field as FieldModel;
use Config\Services;

/**
 * Class UserField
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
class UserField extends Field
{
    private array $options = [];

    /**
     * Field constructor.
     *
     * @param FieldModel $field
     */
    public function __construct(FieldModel $field)
    {
        parent::__construct($field);

        $this->setValue(Services::session()->get(CoreController::SESSION_USER_SID));
    }

    /** @inheritDoc */
    public function display(): string
    {
        $field = '<div class="form-group">';
        $field .= sprintf(
            '<label for="%s">%s</label>',
            $this->identification,
            $this->nameText
        );

        $field .= form_dropdown(
            $this->identification,
            $this->options,
            $this->getValue(),
            $this->getInputOptions()
        );

        $field .= sprintf(
            '<small id="%sHelp" class="form-text text-muted">%s</small>',
            $this->identification,
            $this->helpText
        );
        $field .= '</div>';


        return $field;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}