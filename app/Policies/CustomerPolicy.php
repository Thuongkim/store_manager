<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CustomerPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'customers';
    }
}