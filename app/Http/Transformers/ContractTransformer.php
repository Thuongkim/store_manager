<?php
namespace App\Http\Transformers;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class ContractTransformer
{

    public function transformContract (Collection $contract, $total)
    {

        $array = array();
        foreach ($contract as $contracts) {
            // dd($contracts->files);
            $images = array();

            foreach ($contracts->files as $file) {

                $images[] = $file->url;
            }

            $array[] = self::transformContracts($contracts,$images);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformContracts (Contract $contracts = null, $images)
    {
        

        if ($contracts) {
            $array = [
                'id'            => (int) $contracts->id,
                'number'        => (int) $contracts->number,
                'sign_day'      => $contracts->sign_day,
                'customer'      => $contracts->customer->name,
                'categorize'    => $contracts->categorize->name,
                'duration'      => $contracts->duration,
                'renewed'       => ($contracts->renewed =='1') ? true : false,
                'value'         => $contracts->value,
                'payment'       => $contracts->payment,
                'day_payment'   => $contracts->day_payment,
                'images'        => $images,
                'note'          => e($contracts->note),
                'sale'          => $contracts->sale->name,
                'created_at' => Helper::getFormattedDateObject($contracts->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($contracts->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Contract::class) ? true : false,
                'delete' => Gate::allows('delete', Contract::class) ? true : false,
            ];

            $array += $permissions_array;

           

            return $array;
        }


    }



}
