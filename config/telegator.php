<?php

return [
    'auth' => [
        'password_min_length' => 6,
    ],

    'campaign' => [
        'silence_duration_min' => 60,
        'silence_duration' => 3600, // 1 hour
        'publication_duration_min' => 720,
        'publication_duration' => 43200,
        'hold_before_publication_start_min' => 360,
        'hold_before_publication_start' => 21600,
        'hold_between_publication_start_and_end_min' => 1440,
        'hold_between_publication_start_and_end' => 86400, // 1 day
        'delta_time_min' => 30,
        'delta_time' => 1800, // 30 min
    ]
];
