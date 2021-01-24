<?php

return [
    'title' => [
        'title' => 'Deine Projekte',
        'start' => 'Projekt - {name} - Start',
        'backlog' => 'Projekt - {name} - Backlog',
        'admin' => [
            'general' => [
                'title' => 'Projekt - {name} - Administration - Allgemeine Einstellungen',
                'short' => 'Allgemeine Einstellungen',
            ],
            'ticketTypes' => [
                'title' => 'Projekt - {name} - Administration - Ticket Typen',
                'short' => 'Ticket Typen',
            ],
            'ticketStatus' => [
                'title' => 'Projekt - {name} - Administration - Ticket Status',
                'short' => 'Ticket Status',
            ],
            'ticketFields' => [
                'title' => 'Projekt - {name} - Administration - Ticket Felder',
                'short' => 'Ticket Felder'
            ]
        ]
    ],
    'backlog' => [
        'table' => [
            'id' => '#',
            'title' => 'Titel',
            'assigned' => 'Zugewiesen',
        ]
    ],
    'table' => [
        'ticketFields' => [
            'type' => 'Typ',
            'name' => 'Name',
            'systemField' => 'System'
        ],
        'name' => 'Name',
        'description' => 'Beschreibung',
    ],

    'noMemberOfProject' => 'Projekt wurde nicht gefunden.',
    'noRight' => 'Du hast keine Berechtigung dies zu sehen!',
    'notFound' => 'Projekt wurde nicht gefunden.',
    'ticketType' => [
        'notFound' => 'Ticket Typ wurde nicht gefunden'
    ],
    'ticketStatus' => [
        'notFound' => 'Ticket Status wurde nicht gefunden'
    ],
    'ticketFields' => [
        'notFound' => 'Ticket Feld wurde nicht gefunden',
        'type' => [
            'text' => 'Textfeld',
            'number' => 'Nummernfeld',
            'type' => 'Typ-Auswahlfeld',
            'status' => 'Status-Auswahlfeld',
            'user' => 'Benutzer-Auswahlfeld',
            'textArea' => 'Textarea'
        ]
    ],

    'form' => [
        'ticketType' => [
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Typ (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_space' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!'
                ]
            ],
            'create' => [
                'success' => 'Ticket Typ wurde erfolgreich erstellt.'
            ],
            'edit' => [
                'success' => 'Ticket Typ wurde erfolgreich bearbeitet.'
            ],
            'delete' => [
                'success' => 'Ticket Typ wurde erfolgreich gelöscht.'
            ]
        ],
        'ticketStatus' => [
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Typ (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_space' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!'
                ]
            ],
            'create' => [
                'success' => 'Ticket Status wurde erfolgreich erstellt.'
            ],
            'edit' => [
                'success' => 'Ticket Status wurde erfolgreich bearbeitet.'
            ],
            'delete' => [
                'success' => 'Ticket Status wurde erfolgreich gelöscht.'
            ]
        ],
        'ticketFields' => [
            'identification' => [
                'name' => 'Identifizierungsname',
                'help' => 'Anhand dieses Namens wird das Feld identifiziert (max. 50 Zeichen, Name muss einmalig sein)',
                'validation' => [
                    'required' => 'Du musst einen Identifizierungsname angeben!',
                    'alpha_numeric_space' => 'Du musst einen Identifizierungsname angeben!',
                    'max_length' => 'Der Identifizierungsname darf maximal 50 Zeichen lang sein!',
                    'existsAlready' => 'Dieser Identifizierungsname existiert bereits.'
                ]
            ],
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Feldes (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_punct' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!'
                ]
            ],
            'type' => [
                'name' => 'Typ',
                'help' => 'Typ des Ticket Feldes',
                'validation' => [
                    'required' => 'Du musst einen Typen auswählen!',
                    'in_list' => 'Du musst einen Typen auswählen!'
                ]
            ],
            'description' => [
                'name' => 'Beschreibung',
                'help' => 'Beschreibung des Ticket Feldes (max. 250 Zeichen)',
                'validation' => [
                    'required' => 'Du musst eine Beschreibung angeben!',
                    'alpha_numeric_space' => 'Du musst eine Beschreibung angeben!',
                    'max_length' => 'Die Beschreibung darf maximal 250 Zeichen lang sein!'
                ]
            ],
            'create' => [
                'success' => 'Ticket Feld wurde erfolgreich erstellt.'
            ],
            'edit' => [
                'success' => 'Ticket Feld wurde erfolgreich bearbeitet.'
            ],
            'delete' => [
                'success' => 'Ticket Feld wurde erfolgreich gelöscht.',
                'systemField' => 'Das Ticket Feld wurde vom System erstellt und kann nicht gelöscht werden!'
            ]
        ]
    ]
];
