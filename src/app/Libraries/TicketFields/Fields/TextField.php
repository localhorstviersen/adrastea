<?php

namespace App\Libraries\TicketFields\Fields;

use App\Libraries\TicketFields\Field;

/**
 * Class TextField
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
class TextField extends Field
{
    /** @inheritDoc */
    public function display(): string
    {
        $field = '<div class="form-group">';
        $field .= sprintf(
            '<label for="%s">%s</label>',
            $this->identification,
            $this->nameText
        );

        $field .= form_input(
            $this->identification,
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
}