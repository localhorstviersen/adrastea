<?php


namespace App\Models\DTO;

/**
 * Class UserData
 *
 * @package App\Models\DTO
 * @author  Lars Riße <me@elyday.net>
 */
class UserData
{
    /**
     * @var string|null
     */
    public $sId;

    /**
     * @var string|null
     */
    public $username;

    /**
     * @var string|null
     */
    public $firstName;

    /**
     * @var string|null
     */
    public $surname;

    /**
     * @var string|null
     */
    public $mail;

    /**
     * @var GroupData[]
     */
    public $groups = [];

    /**
     * This method will return a array of all data for an insert into the database.
     *
     * @return array
     */
    public function getDataArray(): array
    {
        return [
            'sId' => $this->sId,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'surname' => $this->surname,
            'mail' => $this->mail
        ];
    }
}