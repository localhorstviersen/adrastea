<?php


namespace App\Libraries\TicketFields;

use App\Models\Project\Ticket;

/**
 * Interface FieldInterface
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
interface FieldInterface
{
    /**
     * @return string
     */
    public function display(): string;

    /**
     * @return array
     */
    public function getValidationRules(): array;

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param  string  $value
     */
    public function setValue(string $value): void;

    /**
     * @param  bool  $required
     */
    public function setRequired(bool $required): void;

    /**
     * @param  bool  $disabled
     */
    public function setDisabled(bool $disabled): void;

    /**
     * @param  string  $rule
     */
    public function addRule(string $rule): void;

    /**
     * @param  array  $params
     */
    public function hydrate(array $params): void;

    /**
     * @param  Ticket  $ticket
     */
    public function hydrateFromTicket(Ticket $ticket): void;

    /**
     * @param  int  $ticketId
     */
    public function storeToDatabase(int $ticketId): void;
}