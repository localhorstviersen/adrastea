<?php

namespace App\Libraries\TicketFields\Fields;

use App\Libraries\TicketFields\Field;
use App\Models\Project\Ticket;

/**
 * Class PredefinedLinkField
 *
 * @package App\Libraries\TicketFields\Fields
 */
class PredefinedLinkField extends Field
{
    private string $predefinedLink;

    /**
     * PredefinedLinkField constructor.
     *
     * @param Ticket\Field $field
     */
    public function __construct(Ticket\Field $field)
    {
        parent::__construct($field);
        $this->predefinedLink = $field->definition;
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

        if ($this->isDisabled()) {
            $link = sprintf($this->predefinedLink, $this->getValue());
            $field .= '<br>';
            $field .= sprintf('<a href="%s">%s</a>', $link, $link);
        }

        $helpText = $this->helpText;

        if (!$this->isDisabled()) {
            $field .= form_input(
                $this->identification,
                $this->getValue(),
                $this->getInputOptions()
            );

            $helpText .= '<br>';
            $helpText .= lang(
                'project.ticketFields.predefinedLink.additionalHelpText',
                ['link' => $this->predefinedLink]
            );
        }

        $field .= sprintf(
            '<small id="%sHelp" class="form-text text-muted">%s</small>',
            $this->identification,
            $helpText
        );
        $field .= '</div>';

        return $field;
    }
}