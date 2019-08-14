<?php
namespace App\Http\Transformers;

use App\Models\Appendix;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class AppendixesTransformer
{

    public function transformAppendixes (Collection $appendixes, $total)
    {
        $array = array();
        foreach ($appendixes as $appendix) {
            $array[] = self::transformAppendix($appendix);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAppendix (Appendix $appendix)
    {
        $array = [
            'id'           => (int) $appendix->id,
            'sign_date' => ($appendix->sign_date) ? Helper::getFormattedDateObject($appendix->sign_date, 'date') : null,
            'duration'     => e($appendix->duration),
            'renewed' => ($appendix->renewed =='1') ? true : false,
            'value'        => ($appendix->value) ? Helper::formatCurrencyOutput($appendix->value) : null,
            'payment'       => ($appendix->payment == '1') ? e('Cash') : e('Bank Transfers'),
            'payment_date' => ($appendix->payment_date) ? Helper::getFormattedDateObject($appendix->payment_date, 'date') : null,
            'note'         => ($appendix->note) ? e($appendix->note) : null,
            'image' => ($appendix->files) ? url('/').'/uploads/appendixes/'.e($appendix->files[0]['url']) : null,
            'number_contract' => ($appendix->contract) ? ['id' => $appendix->contract->id,'number'=> e($appendix->contract->number)] : null,
            'created_at'   => Helper::getFormattedDateObject($appendix->created_at, 'datetime'),
            'updated_at'   => Helper::getFormattedDateObject($appendix->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Appendix::class) ? true : false,
            'checkin' =>  false,
            'update' => Gate::allows('update', Appendix::class) ? true : false,
            'delete' => Gate::allows('delete', Appendix::class) ? true : false,
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
