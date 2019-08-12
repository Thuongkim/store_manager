<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class SalePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'sales';
    }
}
