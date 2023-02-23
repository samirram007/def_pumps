<?php

namespace App\Helpers;

class Helper
{
    public static function getSupport($id): array
    {
        return [
            'id' => $id,
            'name' => 'Support',
            'email' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
        ];
    }
}
