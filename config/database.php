<?php
declare(strict_types=1);

return [
    'url' => sprintf(
        'pgsql://%s:%s@%s:%s/%s',
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_HOST'),
        getenv('DB_PORT') ?: 5432,
        getenv('DB_NAME')
    ),
];
