<?php

namespace App\Libraries\TicketFields\Fields;

use App\Libraries\TicketFields\BoxField;

/**
 * Class RadioBoxField
 *
 * @package App\Libraries\TicketFields\Fields
 */
class RadioBoxField extends BoxField
{
    /** @inheritDoc */
    public function display(): string
    {
        $inputOptions = $this->getInputOptions();
        unset($inputOptions['aria-describedby']);
        $inputOptions['class'] = 'form-check-input';
        $field = '<div class="form-group">';
        $field .= sprintf(
            '<label for="%s">%s</label>',
            $this->identification,
            $this->nameText
        );

        foreach ($this->getOptions() as $option) {
            $inputOptions['id'] = sprintf('%s-%s', $this->identification, str_replace(' ', '_', $option));

            $field .= '<div class="form-check">';
            $field .= form_radio(
                $this->identification,
                $option,
                $this->getValue() === $option,
                $inputOptions
            );
            $field .= sprintf(
                '<label class="form-check-label" for="%s-%s">%s</label>',
                $this->identification,
                str_replace(' ', '_', $option),
                $option
            );
            $field .= '</div>';
        }

        $field .= sprintf(
            '<small id="%sHelp" class="form-text text-muted">%s</small>',
            $this->identification,
            $this->helpText
        );

        $field .= '</div>';

        return $field;
    }
}