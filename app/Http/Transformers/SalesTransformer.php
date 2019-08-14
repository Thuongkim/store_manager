<?php
namespace App\Http\Transformers;

use App\Models\Sale;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class SalesTransformer
{

    public function transformSales (Collection $sales, $total)
    {
        $array = array();
        foreach ($sales as $sale) {
            $array[] = self::transformSale($sale);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformSale (Sale $sale)
    {
        $array = [
            'id'         => (int) $sale->id,
            'name'       => e($sale->name),
            'email'      => e($sale->email),
            'phone'      => e($sale->phone),
            'address'    => e($sale->address),
            'gender'     => ($sale->gender == '1') ? e('Male') : e('Female'),
            'created_at' => Helper::getFormattedDateObject($sale->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($sale->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Sale::class) ? true : false,
            'checkin' =>  false,
            'update' => Gate::allows('update', Sale::class) ? true : false,
            'delete' => Gate::allows('delete', Sale::class) ? true : false,
        ];

        $permissions_array['user_can_checkout'] = false;

        // if ($sale->numRemaining() > 0) {
        //     $permissions_array['user_can_checkout'] = true;
        // }

        $array += $permissions_array;

        return $array;
    }


    // public function transformCheckedoutAccessory ($accessory_users, $total)
    // {


    //     $array = array();
    //     foreach ($accessory_users as $user) {
    //         $array[] = [
    //             'assigned_pivot_id' => $user->pivot->id,
    //             'id' => (int) $user->id,
    //             'username' => e($user->username),
    //             'name' => e($user->getFullNameAttribute()),
    //             'first_name'=> e($user->first_name),
    //             'last_name'=> e($user->last_name),
    //             'employee_number' =>  e($user->employee_num),
    //             'type' => 'user',
    //             'available_actions' => ['checkin' => true]
    //         ];

    //     }

    //     return (new DatatablesTransformer)->transformDatatables($array, $total);
    // }



}
