<?php
return [
    'form' => [
        'alpha_numeric_space' => 'Für das Feld "{field}" sind nur alphanumerische Zeichen erlaubt.',
        'required' => 'Das Feld "{field}" ist ein Pflichtfeld und muss ausgefüllt sein.',
        'numeric' => 'Das Feld "{field}" darf nur Zahlen enthalten.',

        'ticket' => [
            'create' => [
                'success' => 'Ticket wurde erfolgreich erstellt.',
            ],
            'edit' => [
                'success' => 'Ticket wurde erfolgreich bearbeitet.',
            ],
        ],
    ],

    'ticket' => [
        'notFound' => 'Ticket wurde nicht gefunden.',
    ],

    'title' => [
        'ticket' => [
            'view' => 'Projekt - {projectName} - Backlog - Ticket "{ticketTitle}"',
            'create' => 'Projekt - {projectName} - Backlog - Ticket erstellen',
            'edit' => 'Projekt - {projectName} - Backlog - Ticket "{ticketTitle}" bearbeiten',
        ],
    ],
    'noPermissions' => ['attachments' => 'Du darfst keine Anhänge hinzufügen.'],
    'attachments' => [
        'title' => 'Anhang zu Ticket "{ticketTitle}" hinzufügen',
        'form' => [
            'files' => 'Dateien',
            'errors' => [
                'uploaded' => 'Es wurden keine Dateien ausgewählt.',
                'mime_in' => 'Eine der Dateien ist ungültig.',
                'max_size' => 'Eine der Dateien ist zu groß.',
            ],
            'success' => 'Dateien sind erfolgreich angehangen wurden.',
        ],
    ],
];