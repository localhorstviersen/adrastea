<?php

namespace App\Libraries\TicketFields;

/**
 * Class StatusField
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
class StatusField extends Field
{
    private array $options = [];

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
     * @param  array  $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}