<?php
namespace App\Http\Transformers;

use App\Models\Customer;
use App\Models\Warning;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class WarningsTransformer
{

    public function transformWarnings (Collection $warnings, $total)
    {
        $array = array();
        foreach ($warnings as $warning) {
            $array[] = self::transformWarning($warning);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformWarning (Warning $warning)
    {
        $array = [
            'id' => $warning->id,
            'customer' => ($warning->customer) ? ['id' => $warning->customer->id, 'name'=> e($warning->customer->name)] : null,
            'name' => e($warning->name),
            'created_customer_at' => ($warning->customer->created_at) ? e($warning->customer->created_at) : null,
            'duration' => ($warning->duration) ? e($warning->duration) : null,
            'warning_before' => ($warning->warning_before) ? e($warning->warning_before) : null,
            'hour_warning' => ($warning->hour_warning) ? e($warning->hour_warning) : null,
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Warning::class) ? true : false,
            'checkin' =>  false,
            'update' => Gate::allows('update', Warning::class) ? true : false,
            'delete' => Gate::allows('delete', Warning::class) ? true : false,
        ];

        $permissions_array['user_can_checkout'] = false;

        // if ($accessory->numRemaining() > 0) {
        //     $permissions_array['user_can_checkout'] = true;
        // }

        $array += $permissions_array;

        return $array;
    }

    public function transformWarningsDatatable($warnings) {
        return (new DatatablesTransformer)->transformDatatables($warnings);
    }
}
