<?php

namespace App\Libraries\TicketFields\Fields;

use App\Libraries\TicketFields\BoxField;

/**
 * Class CheckBoxField
 *
 * @package App\Libraries\TicketFields
 */
class CheckBoxField extends BoxField
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
            $field .= form_checkbox(
                sprintf('%s-%s', $this->identification, str_replace(' ', '_', $option)),
                $option,
                strpos($this->getValue(), $option) !== false,
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

    /** @inheritDoc */
    public function hydrate(array $params): void
    {
        $value = '';
        foreach ($this->getOptions() as $option) {
            $id = sprintf('%s-%s', $this->identification, str_replace(' ', '_', $option));

            if (isset($params[$id])) {
                if (!empty($value)) {
                    $value .= ';';
                }

                $value .= $params[$id];
            }
        }
        $this->setValue($value);
    }
}