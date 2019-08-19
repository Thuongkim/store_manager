<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class WarningPolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'warnings';
    }
}