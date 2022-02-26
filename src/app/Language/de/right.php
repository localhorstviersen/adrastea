<?php
return [
    'global' => [
        'admin' => [
            'main' => 'Administration',
            'user' => 'Admin: Benutzer bearbeiten',
            'role' => 'Admin: Benutzerrollen bearbeiten',
            'group' => 'Admin: Gruppen bearbeiten',
            'manage' => 'Admin: Projekte verwalten (anlegen, bearbeiten, löschen)',
        ],
    ],
    'project' => [
        'view' => 'Kann das Projekt sehen',
        'ticket' => [
            'view' => [
                'onlyOwn' => 'Kann nur eigene Tickets sehen',
            ],
            'manage' => 'Kann Tickets verwalten (erstellen, bearbeiten)',
            'delete' => 'Kann Tickets löschen',
            'attachFiles' => 'Kann Anhänge zu Tickets hinzufügen',
        ],
        'admin' => 'Projekt Admin',
    ],
];