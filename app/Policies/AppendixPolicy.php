<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class AppendixPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'appendixes';
    }
}
