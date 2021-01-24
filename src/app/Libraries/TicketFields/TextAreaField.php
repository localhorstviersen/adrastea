<?php


namespace App\Libraries\TicketFields;

/**
 * Class TicketAreaField
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
class TextAreaField extends Field
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

        $field .= form_textarea(
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