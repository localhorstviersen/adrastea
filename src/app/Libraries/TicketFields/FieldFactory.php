<?php


namespace App\Libraries\TicketFields;

use App\Models\Project\Ticket\Field;
use App\Models\User;

/**
 * Class FieldFactory
 *
 * @package App\Libraries\TicketFields
 * @author  Lars Riße <me@elyday.net>
 */
class FieldFactory
{
    /**
     * @param  Field  $field
     * @param  bool   $disabled
     *
     * @return FieldInterface|null
     */
    public static function createFieldByModel(Field $field, bool $disabled = false): ?FieldInterface
    {
        $newField = null;

        if ($field->type === Field::TYPE_TEXT) {
            $newField = new TextField($field);

            $newField->addRule('alpha_numeric_space');
        }

        if ($field->type === Field::TYPE_TYPE) {
            $newField = new TypeField($field);

            $newField->setOptions(
                $field->getProject()->getTicketTypesForDropdown()
            );

            $newField->addRule('numeric');
        }

        if ($field->type === Field::TYPE_STATUS) {
            $newField = new StatusField($field);

            $newField->setOptions(
                $field->getProject()->getTicketStatusForDropdown()
            );

            $newField->addRule('numeric');
        }

        if ($field->type === Field::TYPE_USER) {
            $newField = new UserField($field);

            $users = [];
            $users[null] = 'Kein Benutzer';
            $userModel = new User();

            /** @var User $user */
            foreach ($userModel->findAll() as $user) {
                $users[$user->sId] = $user->getFullName();
            }

            $newField->setOptions($users);
            $newField->addRule(sprintf('in_list[%s]', implode(',', array_keys($users))));
        }

        if ($field->type === Field::TYPE_TEXTAREA) {
            $newField = new TextAreaField($field);
        }

        $newField->setDisabled($disabled);
        $newField->setRequired($field->required);

        return $newField;
    }
}