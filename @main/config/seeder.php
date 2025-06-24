<?php

use App\Enums\UserRoles;

return [
    /**
     * Seeded admins
     * @return  Array of Admins to be created by UserFactory
     */
    'eduman_admins' => [
        [
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'phone' => '+8801712499840',
            'email' => 'admin@example.com',
            'role' => UserRoles::ADMIN,
        ],
    ],
];
