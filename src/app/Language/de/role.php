<?php
return [
    'title' => [
        'title' => 'Benutzerrollen',
        'create' => 'Benutzerrolle erstellen',
        'edit' => 'Benutzerrolle "{name}" bearbeiten',
        'delete' => 'Benutzerrolle "{name}" löschen',
    ],
    'table' => [
        'id' => 'ID',
        'name' => 'Name',
    ],
    'form' => [
        'name' => [
            'name' => 'Name',
            'help' => 'Name der Benutzerrolle',
            'validation' => [
                'required' => 'Du musst einen Namen angeben!',
                'alpha_numeric_space' => 'Du musst einen Namen angeben!',
            ]
        ],
        'create.success' => 'Die Benutzerrolle wurde erfolgreich erstellt.',
        'edit.success' => 'Die Benutzerrolle wurde erfolgreich bearbeitet.',
        'delete.success' => 'Die Benutzerrolle wurde erfolgreich gelöscht.',
    ],
    'role' => [
        'notFound' => 'Die Benutzerrolle wurde nicht gefunden!'
    ]
];