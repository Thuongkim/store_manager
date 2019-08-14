<?php
namespace App\Http\Transformers;

use App\Models\Categorize;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class CategorizeTransformer
{

    public function transformCategorize (Collection $categorize, $total)
    {
        $array = array();
        foreach ($categorize as $category) {
            $array[] = self::transformCategorizes($category);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCategorizes (Categorize $category = null)
    {
        if ($category) {

            $array = [
                'id' => (int) $category->id,
                'name' => e($category->name),
                'description' => e($category->description),
                'created_at' => Helper::getFormattedDateObject($category->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($category->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Categorize::class) ? true : false,
                'delete' => Gate::allows('delete', Categorize::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
