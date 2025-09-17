<?php

return [
    'title' => [
        'create' => 'Nieuw Rapport Aanmaken',
        'show' => 'Rapport #:id',
        'details' => 'Rapportdetails',
        'cables' => 'Gevonden Kabels',
        'pipes' => 'Gevonden Leidingen',
        'cables_section' => 'Kabels',
        'pipes_section' => 'Leidingen',
        'work' => 'Werk Informatie',
        'description' => 'Beschrijving',
        'images' => 'Afbeeldingen',
        'timestamps' => 'Tijdstempels',
        'pdf' => 'Rapport #:id',
    ],

    'project' => [
        'for_project' => 'Voor project: :name',
        'label' => 'Project',
        'select' => 'Selecteer een project',
        'number' => 'Project #:number',
        'back' => 'Terug naar Project',
    ],

    'fields' => [
        'project' => 'Project',
        'date_of_work' => 'Werkdatum',
        'work_date' => 'Werkdatum',
        'work_hours' => 'Werkuren',
        'travel_time' => 'Reistijd',
        'cable_type' => 'Kabeltype',
        'material' => 'Materiaal',
        'diameter' => 'Diameter (mm)',
        'pipe_type' => 'Leidingtype',
        'description' => 'Werkbeschrijving',
        'created_by' => 'Aangemaakt Door',
        'field_worker' => 'Monteur',
        'created_at' => 'Aangemaakt Op',
        'updated_at' => 'Laatst Bijgewerkt',
    ],

    'placeholders' => [
        'cable_type' => 'bv. Cat 6, Glasvezel',
        'pipe_type' => 'bv. PVC, HDPE',
        'material' => 'bv. Koper, Aluminium',
        'diameter' => 'bv. 12.5',
        'work_hours' => 'bv. 8 uur, 09:00-17:00',
        'travel_time' => 'bv. 2 uur, 45 minuten',
        'description' => 'Beschrijf het uitgevoerde werk, eventuele problemen en resultaten...'
    ],

    'images' => [
        'upload' => 'Afbeeldingen Uploaden',
        'none' => 'Geen afbeeldingen voor dit rapport.',
        'supported' => 'Je kunt meerdere afbeeldingen selecteren. Ondersteunde formaten: JPG, PNG, GIF, WebP (Max 2MB per stuk)',
        'alt_report_thumb' => 'Rapport miniatuur',
        'alt_new_report_thumb' => 'Nieuwe rapport miniatuur',
        'alt_report_image' => 'Rapportafbeelding',
        'alt_enlarged' => 'Vergrote afbeelding',
    ],

    'actions' => [
        'cancel' => 'Annuleren',
        'reset' => 'Formulier Resetten',
        'create' => 'Rapport Aanmaken',
        'edit' => 'Rapport Bewerken',
        'download' => 'Rapport Downloaden',
        'regenerate' => 'Genereer Rapport Opnieuw',
        'preparing_pdf' => 'PDF aan het voorbereiden...',
    ],

    'cables' => [
        'add' => 'Kabel Toevoegen',
        'no_results' => 'Geen resultaten',
        'none' => 'Niet van toepassing',
        'material' => [
            'plastic' => 'Kunststof',
        ]
    ],

    'pipes' => [
        'add' => 'Leiding Toevoegen',
        'no_results' => 'Geen resultaten',
        'none' => 'Niet van toepassing',
        'material' => [
            'steel' => 'Staal',
            'copper' => 'Koper'
        ]
    ],

    'status' => [
        'n_a' => 'n.v.t.'
    ],
];
