<?php

return [
    'title' => [
        'title' => 'Deine Projekte',
        'start' => 'Projekt - {name} - Start',
        'backlog' => 'Projekt - {name} - Backlog',
        'kanban' => 'Projekt - {name} - Kanban Board',
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
                'short' => 'Ticket Felder',
            ],
        ],
    ],
    'backlog' => [
        'table' => [
            'id' => '#',
            'title' => 'Titel',
            'status' => 'Status',
            'type' => 'Ticket-Typ',
            'assigned' => 'Zugewiesen',
            'reporter' => 'Melder',
        ],
    ],
    'table' => [
        'ticketStatus' => [
            'priority' => 'Priorität',
        ],
        'ticketFields' => [
            'ticketType' => 'Ticket-Typ',
            'type' => 'Typ',
            'name' => 'Name',
            'systemField' => 'System',
            'required' => 'Pflichtfeld',
        ],
        'name' => 'Name',
        'description' => 'Beschreibung',
    ],

    'noMemberOfProject' => 'Projekt wurde nicht gefunden.',
    'noRight' => 'Du hast keine Berechtigung dies zu sehen!',
    'notFound' => 'Projekt wurde nicht gefunden.',
    'ticketType' => [
        'notFound' => 'Ticket Typ wurde nicht gefunden',
    ],
    'ticketStatus' => [
        'notFound' => 'Ticket Status wurde nicht gefunden',
    ],
    'ticketFields' => [
        'notFound' => 'Ticket Feld wurde nicht gefunden',
        'type' => [
            'text' => 'Textfeld',
            'number' => 'Nummernfeld',
            'type' => 'Typ-Auswahlfeld',
            'status' => 'Status-Auswahlfeld',
            'user' => 'Benutzer-Auswahlfeld',
            'textArea' => 'Textarea',
            'radioBox' => 'Radio Box',
            'checkBox' => 'Check Box',
            'predefinedLink' => 'Vordefinierter Link',
        ],
        'predefinedLink' => [
            'additionalHelpText' => 'Bei diesem Feld handelt es sich um einen sog. "Vordefinierten Link". Die hier vorgenommene Eingabe wird in der View-Ansicht dieses Tickets Bestandteil des folgenden Links: "{link}" (%s ist hierbei der Platzhalter für die Eingabe).',
        ],
    ],

    'form' => [
        'ticketType' => [
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Typ (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_space' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!',
                ],
            ],
            'create' => [
                'success' => 'Ticket Typ wurde erfolgreich erstellt.',
            ],
            'edit' => [
                'success' => 'Ticket Typ wurde erfolgreich bearbeitet.',
            ],
            'delete' => [
                'success' => 'Ticket Typ wurde erfolgreich gelöscht.',
            ],
        ],
        'ticketStatus' => [
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Typ (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_space' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!',
                ],
            ],
            'priority' => [
                'name' => 'Priorität',
                'help' => 'Anhand dieser Zahl wird entschieden, an welcher Stelle dieser Status im Kanban Board dargestellt wird.',
                'validation' => [
                    'required' => 'Du musst eine Priorität angeben!',
                    'numeric' => 'Du musst eine Priorität angeben!',
                ],
            ],
            'create' => [
                'success' => 'Ticket Status wurde erfolgreich erstellt.',
            ],
            'edit' => [
                'success' => 'Ticket Status wurde erfolgreich bearbeitet.',
            ],
            'delete' => [
                'success' => 'Ticket Status wurde erfolgreich gelöscht.',
            ],
        ],
        'ticketFields' => [
            'identification' => [
                'name' => 'Identifizierungsname',
                'help' => 'Anhand dieses Namens wird das Feld identifiziert (max. 50 Zeichen, Name muss einmalig sein)',
                'validation' => [
                    'required' => 'Du musst einen Identifizierungsname angeben!',
                    'alpha_numeric_space' => 'Du musst einen Identifizierungsname angeben!',
                    'max_length' => 'Der Identifizierungsname darf maximal 50 Zeichen lang sein!',
                    'existsAlready' => 'Dieser Identifizierungsname existiert bereits.',
                ],
            ],
            'name' => [
                'name' => 'Name',
                'help' => 'Name des Ticket Feldes (max. 50 Zeichen)',
                'validation' => [
                    'required' => 'Du musst einen Namen angeben!',
                    'alpha_numeric_punct' => 'Du musst einen Namen angeben!',
                    'max_length' => 'Der Name darf maximal 50 Zeichen lang sein!',
                ],
            ],
            'ticketType' => [
                'name' => 'Ticket-Typ',
                'help' => 'Mit dieser Einstellung hat man die Möglichkeit, ein Feld nur für bestimmte Ticket Typen darstellen zu lassen.',
                'validation' => [
                    'in_list' => 'Ticket-Typ ungültig!',
                ],
            ],
            'type' => [
                'name' => 'Typ',
                'help' => 'Typ des Ticket Feldes',
                'validation' => [
                    'required' => 'Du musst einen Typen auswählen!',
                    'in_list' => 'Du musst einen Typen auswählen!',
                ],
            ],
            'definition' => [
                'name' => 'Feld Definition',
                'help' => [
                    'default' => 'Lorem Ipsum',
                    'selectFields' => 'Bitte gebe die möglichen Auswahl-Möglichkeiten mit einem ";" separiert ein.',
                    'predefinedLinkField' => 'Mit diesem Feld-Typen kann man einen Link vorgeben, welcher mittels einem Platzhalter durch User-Input erweitert werden kann. Der Platzhalter ist %s und darf nur ein mal im String vorkommen.',
                ],
                'validation' => [
                    'required' => 'Es muss eine Definition angegeben werden.',
                    'regex_match' => 'Die angegebene Definition ist nicht gültig.',
                    'moreThanOne' => 'Der Platzhalter muss ein mal in der Definition vorkommen.',
                ],
            ],
            'description' => [
                'name' => 'Beschreibung',
                'help' => 'Beschreibung des Ticket Feldes (max. 250 Zeichen)',
                'validation' => [
                    'required' => 'Du musst eine Beschreibung angeben!',
                    'alpha_numeric_space' => 'Du musst eine Beschreibung angeben!',
                    'max_length' => 'Die Beschreibung darf maximal 250 Zeichen lang sein!',
                ],
            ],
            'required' => [
                'name' => 'Pflichtfeld',
                'help' => 'Ist dieses Feld ein Pflichtfeld?',
                'validation' => [
                    'required' => 'Du musst etwas angeben!',
                ],
            ],
            'create' => [
                'success' => 'Ticket Feld wurde erfolgreich erstellt.',
            ],
            'edit' => [
                'success' => 'Ticket Feld wurde erfolgreich bearbeitet.',
            ],
            'delete' => [
                'success' => 'Ticket Feld wurde erfolgreich gelöscht.',
                'systemField' => 'Das Ticket Feld wurde vom System erstellt und kann nicht gelöscht werden!',
            ],
        ],
    ],
];
