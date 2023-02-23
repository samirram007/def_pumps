<?php

// use UserService;
namespace App\Http\UserService;

use UserRepository;

 class UserService
 {
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($data)
    {
        $user = $this->userRepository->create($data);
        return $user;
    }
}
