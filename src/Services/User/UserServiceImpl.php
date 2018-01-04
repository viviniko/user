<?php

namespace Viviniko\User\Services\User;

use Viviniko\User\Contracts\UserService;
use Viviniko\User\Repositories\User\UserRepository;

class UserServiceImpl implements UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}