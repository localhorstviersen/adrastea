<?php
return [
    'project' => [
        'title' => [
            'title' => 'Projekt Übersicht',
            'create' => 'Projekt erstellen',
            'edit' => 'Projekt "{name}" bearbeiten',
            'delete' => 'Projekt "{name}" löschen',
            'managePermissions' => 'Berechtigungen des Projektes "{name}" bearbeiten',
        ],
        'table' => [
            'name' => 'Name',
            'description' => 'Beschreibung',
            'createdAt' => 'Erstellt am',
        ],
        'notFound' => 'Projekt wurde nicht gefunden.',
        'form' => [
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Projektes (max 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_space' => 'Es sind nur Alpha-numerische Zeichen im Namen erlaubt!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!',
                ]
            ],
            'description' => [
                'name' => 'Beschreibung',
                'help' => 'Beschreibung des Projektes (max 500 Zeichen)',
                'validation' => [
                    'required' => 'Du musst eine Beschreibung angeben!',
                    'alpha_numeric_space' => 'Es sind nur Alpha-numerische Zeichen in der Beschreibung erlaubt!',
                    'max_length' => 'Die Beschreibung darf maximal 500 Zeichen lang sein!',
                ]
            ],
            'createSuccess' => 'Das Projekt wurde erfolgreich erstellt.',
            'editSuccess' => 'Das Projekt wurde erfolgreich bearbeitet.',
            'deleteSuccess' => 'Das Projekt wurde erfolgreich gelöscht.',
            'managePermissionsSuccess' => 'Die Rechte wurden erfolgreich zugewiesen'
        ],
    ]
];