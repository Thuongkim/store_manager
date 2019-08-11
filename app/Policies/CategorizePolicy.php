<?php

namespace App\Policies;

use App\Policies\SnipePermissionsPolicy;

class CategorizePolicy extends SnipePermissionsPolicy
{
    protected function columnName()
    {
        return 'categorize';
    }
}
