<?php
declare(strict_types=1);
return [
    [
        'name' => 'Talk in the future',
        'type' => 'talk',
        'date' => new DateTime('+1 day'),
        'event' => 'PHPSW',
        'abstract' => 'This is the talk in the future abstract',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/1234', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Talk in the past',
        'type' => 'talk',
        'date' => new DateTime('1970-01-01'),
        'event' => 'A great conference',
        'abstract' => 'This is the talk in the past abstract',
        'links' => [],
    ],
    [
        'name' => 'Tutorial in the past',
        'type' => 'tutorial',
        'date' => new DateTime('1970-01-02'),
        'event' => 'Another conference',
        'abstract' => 'This is the tutorial abstract',
        'links' => [],
    ],
    [
        'name' => 'Lightning talk in the past',
        'type' => 'tutorial',
        'date' => new DateTime('1970-01-03'),
        'event' => 'An interesting conference',
        'abstract' => 'Lightning talk in the past abstract',
        'links' => [],
    ],
];
