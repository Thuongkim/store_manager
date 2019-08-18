<?php
namespace App\Http\Transformers;

use App\Models\Customer;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class CustomersTransformer
{

    public function transformCustomers (Collection $customers, $total)
    {
        $array = array();
        foreach ($customers as $customer) {
            $array[] = self::transformCustomer($customer);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCustomer (Customer $customer)
    {
        $array = [
            'id' => $customer->id,
            'name' => e($customer->name),
            'phone' => ($customer->phone) ? e($customer->phone) : null,
            'duration' => ($customer->duration) ? e($customer->duration) : null,
            'address' => ($customer->address) ? e($customer->address) : null,
            'city' => ($customer->city) ? e($customer->city) : null,
            'state' => ($customer->state) ? e($customer->state) : null,
            'country' => ($customer->country) ? e($customer->country) : null,
            'zip' => ($customer->zip) ? e($customer->zip) : null,
            'taxcode' => ($customer->taxcode) ? e($customer->taxcode) : null,
            'email' => e($customer->email),
            'created_at' => Helper::getFormattedDateObject($customer->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($customer->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Customer::class) ? true : false,
            'checkin' =>  false,
            'update' => Gate::allows('update', Customer::class) ? true : false,
            'delete' => Gate::allows('delete', Customer::class) ? true : false,
        ];

        $permissions_array['user_can_checkout'] = false;

        // if ($accessory->numRemaining() > 0) {
        //     $permissions_array['user_can_checkout'] = true;
        // }

        $array += $permissions_array;

        return $array;
    }

    public function transformcustomersDatatable($customers) {
        return (new DatatablesTransformer)->transformDatatables($customers);
    }

}
