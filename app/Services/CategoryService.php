<?php

namespace App\Services;

class CategoryService
{
    const EXCLUDE_FIELDS = [
        'type',
        'where',
        'when',
        'cost',
        'summary'
    ];

    const EXCLUDE_FIELD_VALUES = [
        'where' => [
            'australia-wide',
            'states',
////            'local-area',
////            'location',
            'suburbs',
            'radius'
        ],
        'when'  => [
            'ongoing',
            'now',
            'flexible',
            'upon-request',
            'range',
            'fixed'
        ],
    ];

    const CATEGORIES = [
        'Collaboration'    => [
            'Projects'             => [],
            'Social Enterprise'    => [],
            'Tenders'              => [],
            'Auspice Arrangements' => []
        ],
        'Resources'        => [
            'Back office services'  => [
                'Administration',
                'Operations',
                'IT',
                'Archiving',
                'Records',
                'Finances'
            ],
            'Premises'              => [
                'Lease',
                'License',
                'Commercial Kitchen',
                'Venue'
            ],
            'Professional Services' => [
                'Accounting',
                'Book-Keeping',
                'Legal and Risk Management',
                'Marketing',
                'Consulting'
            ],
            'Equipment'             => [],
            'Vehicles'              => [],
            'Volunteers'            => [],
            'Programs'              => [],
            'Technology'            => []
        ],
        'Potential Merger' => [
            'Acquisition'     => [],
            'Merger'          => [],
            'Corporate Group' => []
        ],
        'Sponsorship'      => [
            'For project'  => [],
            'For an Event' => [],
            'On going'     => []
        ],
        'Governance'       => [
            'Directors'         => [],
            'Company Secretary' => [],
        ],
    ];

    const CUSTOM_LABELS = [
        'Projects'                  => [
            'type'    => [
                'offer'   => 'We would like to collaborate with others who have a project or a proposed project',
                'looking' => 'We have a project or a proposed project and would like others to collaborate with',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the project based/would you like the project to be based?',
            'when'    => [
                'title'   => 'When is the project happening/should the project happen?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time',
            ],
            'summary' => [
                'label'       => 'What are the details of the project/what would you like the project to be?',
                'placeholder' => 'Please provide a short summary of the proposed/desired project',
            ],
        ],
        'Social Enterprise'         => [
            'type'    => [
                'offer'   => 'We would like to collaborate with others who have a social enterprise or a proposed social enterprise',
                'looking' => 'We have a social enterprise or a proposed social enterprise and would like others to collaborate with',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the social enterprise going to be/should the social enterprise be located?',
            'when'    => [
                'title'    => 'When will the social enterprise/should the social enterprise operate?',
                'ongoing'  => 'Already operating',
                'flexible' => 'Flexible commencement date',
                'range'    => 'For a period of time',
            ],
            'summary' => [
                'label'       => 'What are the details of the social enterprise/what would you like the social enterprise to be like?',
                'placeholder' => 'Please provide a short summary of the proposed/desired social enterprise',
            ],
        ],
        'Tenders'                   => [
            'type'    => [
                'offer'   => 'We would like to collaborate with others who have a tender or a proposed tender',
                'looking' => 'We have a tender or a proposed tender and would like others to collaborate with',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the tender/should the tender be focused?',
            'when'    => [
                'title'    => 'When will/should the tender occur?',
                'ongoing'  => 'Already underway',
                'flexible' => 'Flexible regarding dates',
                'fixed'    => 'At a fixed time',
            ],
            'summary' => [
                'label'       => 'What are the details of the tender/what you would like to tender for?',
                'placeholder' => 'Please provide a short summary of the proposed/desired tender',
            ],
        ],
        'Auspice Arrangements'      => [
            'type'    => [
                'offer'   => 'We would like to be provided an auspice arrangement',
                'looking' => 'We would like to provide an auspice arrangement',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the auspice arrangement offered/desired?',
            'when'    => [
                'title'    => 'When will/should the auspice arrangement occur?',
                'ongoing'  => 'Ongoing',
                'flexible' => 'Flexible regarding dates'
            ],
            'summary' => [
                'label'       => 'What are the details of the auspice arrangement offered/desired?',
                'placeholder' => 'Please provide a short summary of the proposed/desired auspice arrangement',
            ],
        ],
        'Administration'            => [
            'type'    => [
                'offer'   => 'We are offering administration support',
                'looking' => 'We are searching for administration support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the administrative support offered/required?',
            'when'    => [
                'title'   => 'When is the administrative support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the administrative support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the administrative support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the administration support offered/required',
            ],
        ],
        'Operations'                => [
            'type'    => [
                'offer'   => 'We are offering operations support',
                'looking' => 'We are searching for operations support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the operations support offered/required?',
            'when'    => [
                'title'   => 'When is the operations support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the operations support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the operations support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the operations support offered/required',
            ],
        ],
        'IT'                        => [
            'type'    => [
                'offer'   => 'We are offering IT support',
                'looking' => 'We are searching for IT support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the IT support offered/required?',
            'when'    => [
                'title'   => 'When is the IT support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the IT support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the IT support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the IT support offered/required',
            ],
        ],
        'Archiving'                 => [
            'type'    => [
                'offer'   => 'We are offering archiving support',
                'looking' => 'We are searching for archiving support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the archiving support offered/required?',
            'when'    => [
                'title'   => 'When is the archiving support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the archiving support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the archiving support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the archiving support offered/required',
            ],
        ],
        'Records'                   => [
            'type'    => [
                'offer'   => 'We are offering support regarding records',
                'looking' => 'We are searching for support regarding records',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the records support offered/required?',
            'when'    => [
                'title'   => 'When is the records support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the records support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the records support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the support regarding records offered/required',
            ],
        ],
        'Finances'                  => [
            'type'    => [
                'offer'   => 'We are offering support regarding finances',
                'looking' => 'We are searching for support regarding finances',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the finances support offered/required?',
            'when'    => [
                'title'   => 'When is the finances support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the finances support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the finances support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the support regarding finances offered/required',
            ],
        ],
        'Equipment'                 => [
            'type'    => [
                'offer'   => 'We are offering equipment',
                'looking' => 'We are searching for equipment',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the equipment offered/required?',
            'when'    => [
                'title'        => 'When is the equipment offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the equipment?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the equipment being offered/sought?',
                'placeholder' => 'Please provide a short summary of the equipment offered/required',
            ],
        ],
        'Lease'                     => [
            'type'    => [
                'offer'   => 'We are offering a premises for lease',
                'looking' => 'We are searching for a premises for lease',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the lease of premises offered/required?',
            'when'    => [
                'title'   => 'When is the lease of premises offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the lease of premise?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the lease of premises being offered/sought?',
                'placeholder' => 'Please provide a short summary of the lease of premises offered/required',
            ],
        ],
        'License'                   => [
            'type'    => [
                'offer'   => 'We are offering a premises for license',
                'looking' => 'We are searching for a premises for license',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the license of premises offered/required?',
            'when'    => [
                'title'   => 'When is the license of premises offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the license of premise?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the license of premises being offered/sought?',
                'placeholder' => 'Please provide a short summary of the license of premises offered/required',
            ],
        ],
        'Commercial Kitchen'        => [
            'type'    => [
                'offer'   => 'We are offering a commercial kitchen for use',
                'looking' => 'We are searching for a commercial kitchen for use',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the use of a commercial kitchen offered/required?',
            'when'    => [
                'title'        => 'When is the use of a commercial kitchen offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the commercial kitchen use?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the commercial kitchen being offered/sought?',
                'placeholder' => 'Please provide a short summary of the commercial kitchen is offered/required',
            ],
        ],
        'Venue'                     => [
            'type'    => [
                'offer'   => 'We are offering a venue for use',
                'looking' => 'We are searching for a venue for use',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the use of venue offered/required?',
            'when'    => [
                'title'        => 'When is the use of venue offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the use of venue?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the use of venue being offered/sought?',
                'placeholder' => 'Please provide a short summary of the use of venue offered/required',
            ],
        ],
        'Accounting'                => [
            'type'    => [
                'offer'   => 'We are offering accounting support',
                'looking' => 'We are searching for accounting support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the accounting support offered/required?',
            'when'    => [
                'title'   => 'When is the accounting support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the accounting support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the accounting support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the accounting support offered/required',
            ],
        ],
        'Book-Keeping'              => [
            'type'    => [
                'offer'   => 'We are offering book-keeping support',
                'looking' => 'We are searching for book-keeping support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the book-keeping support offered/required?',
            'when'    => [
                'title'   => 'When is the book-keeping support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the book-keeping support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the book-keeping support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the book-keeping support offered/required',
            ],
        ],
        'Legal and Risk Management' => [
            'type'    => [
                'offer'   => 'We are offering legal and/or risk management support',
                'looking' => 'We are searching for legal and/or risk management support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the legal and risk management support offered/required?',
            'when'    => [
                'title'   => 'When is the legal and risk management support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the legal and risk management support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the legal and risk management support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the legal and/or risk management support offered/required',
            ],
        ],
        'Marketing'                 => [
            'type'    => [
                'offer'   => 'We are offering marketing support',
                'looking' => 'We are searching for marketing support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the marketing support offered/required?',
            'when'    => [
                'title'   => 'When is the marketing support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the marketing support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the marketing support being offered/sought?',
                'placeholder' => 'Please provide a short summary of marketing support offered/required',
            ],
        ],
        'Consulting'                => [
            'type'    => [
                'offer'   => 'We are offering consulting support',
                'looking' => 'We are searching for consulting support',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the consulting support offered/required?',
            'when'    => [
                'title'   => 'When is the consulting support offered/required?',
                'ongoing' => 'Ongoing',
                'range'   => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the consulting support?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the consulting support being offered/sought?',
                'placeholder' => 'Please provide a short summary of the consulting support offered/required',
            ],
        ],
        'Vehicles'                  => [
            'type'    => [
                'offer'   => 'We are offering a vehicle/vehicles',
                'looking' => 'We are searching for a vehicle/vehicles',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the vehicle(s) offered/required?',
            'when'    => [
                'title'        => 'When is the vehicle(s) offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the vehicle(s)?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the vehicle(s) being offered/sought?',
                'placeholder' => 'Please provide a short summary of the vehicle(s) offered/required',
            ],
        ],
        'Volunteers'                => [
            'where'   => 'Where are volunteer(s) required?',
            'when'    => [
                'title'        => 'When are the volunteers required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'summary' => [
                'label'       => 'What are the details of the volunteer(s) being sought?',
                'placeholder' => 'Please provide a short summary of the volunteer(s) required',
            ],
        ],
        'Programs'                  => [
            'type'    => [
                'offer'   => 'We are offering programs',
                'looking' => 'We are searching for programs',
                'both'    => 'Both'
            ],
            'where'   => 'Where are the programs offered/required?',
            'when'    => [
                'title'        => 'When are the program(s) offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the program(s)?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the program(s) being offered/sought?',
                'placeholder' => 'Please provide a short summary of the program(s) offered/required',
            ],
        ],
        'Technology'                => [
            'type'    => [
                'offer'   => 'We are offering technology resources',
                'looking' => 'We are searching for technology resources',
                'both'    => 'Both'
            ],
            'where'   => 'Where are the technology resources offered/required?',
            'when'    => [
                'title'        => 'When are the technology resources offered/required?',
                'ongoing'      => 'Ongoing',
                'upon-request' => 'Upon Request',
                'fixed'        => 'At specific times',
                'range'        => 'For a period of time'
            ],
            'cost'    => [
                'title' => 'What cost would be expected/desired for the technology resources?',
                'free'  => 'No Cost',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the technology resources being offered/sought?',
                'placeholder' => 'Please provide a short summary of the technology resources offered/required',
            ],
        ],
        'Acquisition'               => [
            'type'    => [
                'offer'   => 'We would like another entity to acquire us',
                'looking' => 'We are looking to acquire other entities',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the acquisition to occur/required to occur?',
            'when'    => [
                'title' => 'When is the acquisition to occur/desired to occur?',
                'now'   => 'Now',
                'fixed' => 'At a later date'
            ],
            'summary' => [
                'label'       => 'What are the details of the acquisition being offered/sought?',
                'placeholder' => 'Please provide a short summary of the proposed/desired acquisition',
            ],
        ],
        'Merger'                    => [
            'where'   => 'Where is the merger to occur/required to occur?',
            'when'    => [
                'title' => 'When is the merger to occur/desired to occur?',
                'now'   => 'Now',
                'fixed' => 'At a later date'
            ],
            'summary' => [
                'label'       => 'What are the details of the merger being offered/sought?',
                'placeholder' => 'Please provide a short summary of the proposed/desired merger',
            ],
        ],
        'Corporate Group'           => [
            'type'    => [
                'offer'   => 'We would like to identify other entities to join our corporate group',
                'looking' => 'We are looking to join a corporate group',
                'both'    => 'Both'
            ],
            'where'   => 'Where is the joining of a corporate group to occur/required to occur?',
            'when'    => [
                'title' => 'When is the joining of a corporate group to occur/desired to occur?',
                'now'   => 'Now',
                'fixed' => 'At a later date'
            ],
            'summary' => [
                'label'       => 'What are the details of the joining of a corporate group being offered/sought?',
                'placeholder' => 'Please provide a short summary of the proposed/desired joining of a corporate group',
            ],
        ],
        'For project'               => [
            'where'   => 'Where is the sponsorship of an event desired?',
            'when'    => [
                'title'    => 'When is the sponsorship of an event desired?',
                'flexible' => 'Flexible – when required',
                'range'    => 'At a specific time'
            ],
            'cost'    => [
                'title' => 'What amount of sponsorship is desired?',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the sponsorship of an event being sought?',
                'placeholder' => 'Please provide a short summary of the sponsorship of an event desired',
            ],
        ],
        'For an Event'              => [
            'where'   => 'Where is the sponsorship of a project desired?',
            'when'    => [
                'title'    => 'When is the sponsorship of a project desired?',
                'ongoing'  => 'Ongoing',
                'flexible' => 'Flexible – when required',
                'range'    => 'At a specific time'
            ],
            'cost'    => [
                'title' => 'What amount of sponsorship is desired?',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the sponsorship of a project desired?',
                'placeholder' => 'Please provide a short summary of the sponsorship of a project desired',
            ],
        ],
        'On going'                  => [
            'where'   => 'Where is the ongoing/once off sponsorship desired?',
            'cost'    => [
                'title' => 'What amount of sponsorship is desired?',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the ongoing/once off sponsorship being sought?',
                'placeholder' => 'Please provide a short summary of the ongoing/once off sponsorship desired',
            ],
        ],
        'Directors'                 => [
            'where'   => 'Where are director(s) required?',
            'when'    => [
                'title' => 'When are director(s) required?',
                'now'   => 'Immediately',
                'fixed' => 'At a future date',
            ],
            'cost'    => [
                'title' => 'Are director(s) to be paid?',
                'free'  => 'No Payment',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the director(s) being sought?',
                'placeholder' => 'Please provide a short summary of the director(s) required',
            ],
        ],
        'Company Secretary'         => [
            'where'   => 'Where is the company secretary required?',
            'when'    => [
                'title' => 'When is a company secretary required?',
                'now'   => 'Immediately',
                'fixed' => 'At a future date',
            ],
            'cost'    => [
                'title' => 'Is the company secretary to be paid?',
                'free'  => 'No Payment',
                'range' => 'Range',
                'fixed' => 'Fixed Amount',
            ],
            'summary' => [
                'label'       => 'What are the details of the company secretary being sought?',
                'placeholder' => 'Please provide a short summary of the company secretary required',
            ],
        ],
    ];

    // fields - type, where, when, cost, summary
    const CATEGORY_EXCLUDE_FIELDS = [
        'Projects' => [
            'cost'
        ],

        'Social Enterprise' => [
            'cost'
        ],

        'Tenders' => [
            'cost'
        ],

        'Auspice Arrangements' => [
            'cost'
        ],

        'Volunteers' => [
            'type',
            'cost'
        ],

        'Acquisition' => [
            'cost'
        ],

        'Merger' => [
            'type',
            'cost'
        ],

        'Corporate Group' => [
            'cost'
        ],

        'For project' => [
            'type',
        ],

        'For an Event' => [
            'type',
        ],

        'On going' => [
            'type',
            'when'
        ],

        'Directors' => [
            'type'
        ],

        'Company Secretary' => [
            'type'
        ],
    ];

    const CATEGORY_EXCLUDE_FIELD_VALUES = [
        'Projects' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Social Enterprise' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'upon-request',
                'fixed'
            ],
        ],

        'Tenders' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'upon-request',
                'range'
            ],
        ],

        'Auspice Arrangements' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'upon-request',
                'range',
                'fixed'
            ],
        ],

        'Administration' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Operations' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'IT' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Archiving' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Records' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Finances' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Lease' => [
            'where' => [
                'australia-wide',
                'suburbs',
//                'local-area',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'License' => [
            'where' => [
                'australia-wide',
                'suburbs',
//                'local-area',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Commercial Kitchen' => [
            'where' => [
                'australia-wide',
                'suburbs',
//                'local-area',
            ],
            'when'  => [
                'now',
                'flexible',
            ],
        ],

        'Venue' => [
            'where' => [
                'australia-wide',
                'suburbs',
//                'local-area',
            ],
            'when'  => [
                'now',
                'flexible',
            ],
        ],

        'Accounting' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Book-Keeping' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Legal and Risk Management' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Marketing' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Consulting' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'upon-request',
                'fixed'
            ],
        ],

        'Equipment' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible'
            ],
        ],

        'Vehicles' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
            ],
        ],

        'Volunteers' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible',
                'range'
            ],
        ],

        'Programs' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible'
            ],
        ],

        'Technology' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'flexible'
            ],
        ],

        'Acquisition' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'range',
                'flexible',
                'upon-request'
            ],
        ],

        'Merger' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'range',
                'flexible',
                'upon-request'
            ],
        ],

        'Corporate Group' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'range',
                'flexible',
                'upon-request'
            ],
        ],

        'For project' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'now',
                'upon-request',
                'fixed'
            ],
        ],

        'For an Event' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'now',
                'upon-request',
                'fixed'
            ],
        ],

        'On going' => [
            'where' => [
                'suburbs',
//                'location',
            ]
        ],

        'Directors' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'flexible',
                'upon-request',
                'range'
            ]
        ],

        'Company Secretary' => [
            'where' => [
                'suburbs',
//                'location',
            ],
            'when'  => [
                'ongoing',
                'flexible',
                'upon-request',
                'range'
            ]
        ],
    ];
}
