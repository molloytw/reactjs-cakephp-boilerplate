<?php

namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
        'sortWhitelist' => [
            'id', 'username', 'user_type'
        ]
    ];
}