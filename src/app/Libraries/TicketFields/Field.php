<?php


namespace App\Libraries\TicketFields;

use App\Models\Project\Ticket;
use ReflectionException;

/**
 * Class Field
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
abstract class Field implements FieldInterface
{
    private Ticket\Field $field;

    protected string $identification;
    protected string $nameText;
    protected string $helpText;
    private bool $required = false;
    private bool $disabled = false;
    private ?string $value;

    private array $rules = [];

    /**
     * Field constructor.
     *
     * @param Ticket\Field $field
     */
    public function __construct(Ticket\Field $field)
    {
        $this->field = $field;

        $this->identification = $field->identification;
        $this->nameText = $field->name;
        $this->helpText = $field->description;
        $this->value = '';
    }

    /** @inheritDoc */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /** @inheritDoc */
    public function setValue(?string $value): void
    {
        $this->value = $value ?? '';
    }

    /** @inheritDoc */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /** @inheritDoc */
    public function setRequired(bool $required): void
    {
        $this->required = $required;

        if ($required) {
            if (!in_array('required', $this->rules, true)) {
                $this->addRule('required');
            }
        } else {
            $key = array_search('required', $this->rules, true);
            if (!empty($key)) {
                unset($this->rules[$key]);
            }
        }
    }

    /** @inheritDoc */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /** @inheritDoc */
    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    /** @inheritDoc */
    public function addRule(string $rule): void
    {
        $this->rules[] = $rule;
    }

    /** @inheritDoc */
    public function hydrate(array $params): void
    {
        if (isset($params[$this->identification])) {
            $this->setValue($params[$this->identification]);
        }
    }

    /** @inheritDoc */
    public function hydrateFromTicket(Ticket $ticket): void
    {
        $this->setValue($ticket->getFieldValue($this->identification));
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function storeToDatabase(int $ticketId, TicketFieldManager $manager): void
    {
        $this->field->setValue($ticketId, $this->value);
    }

    /**
     * @return string
     */
    public function getIdentification(): string
    {
        return $this->identification;
    }

    /** @inheritDoc */
    public function getValidationRules(): array
    {
        if (empty($this->getRules())) {
            return [];
        }

        if (!$this->required && empty($this->value)) {
            return [];
        }

        return [
            $this->identification => [
                'label' => $this->nameText,
                'rules' => $this->getRules(),
                'errors' => $this->getErrorMessages(),
            ],
        ];
    }

    /**
     * @return string
     */
    final protected function getRules(): string
    {
        return implode('|', $this->rules);
    }

    /**
     * This method defines all possible error messages.
     *
     * @return string[]
     */
    protected function getErrorMessages(): array
    {
        return [
            'alpha_numeric_space' => 'backlog.form.alpha_numeric_space',
            'required' => 'backlog.form.required',
            'numeric' => 'backlog.form.numeric',
        ];
    }

    /**
     * @return array
     */
    protected function getInputOptions(): array
    {
        $options = [
            'id' => $this->identification,
            'class' => 'form-control',
            'aria-describedby' => $this->identification . 'Help',
        ];

        if ($this->required) {
            $options['required'] = 'required';
        }

        if ($this->disabled) {
            $options['disabled'] = 'disabled';
        }

        return $options;
    }
}