<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Sale;
use App\Http\Transformers\SalesTransformer;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Sale::class);
        $allowed_columns = ['id','name','email','phone','address','gender'];

        $sales = new Sale();

        if ($request->filled('search')) {
            $sales = $sales->TextSearch($request->input('search'));
        }

        // if ($request->filled('company_id')) {
        //     $accessories->where('company_id','=',$request->input('company_id'));
        // }

        // if ($request->filled('category_id')) {
        //     $accessories->where('category_id','=',$request->input('category_id'));
        // }

        // if ($request->filled('manufacturer_id')) {
        //     $accessories->where('manufacturer_id','=',$request->input('manufacturer_id'));
        // }

        // if ($request->filled('supplier_id')) {
        //     $accessories->where('supplier_id','=',$request->input('supplier_id'));
        // }
        $offset = (($sales) && (request('offset') > $sales->count())) ? 0 : request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        // switch ($sort) {
        //     case 'category':
        //         $accessories = $accessories->OrderCategory($order);
        //         break;
        //     case 'company':
        //         $accessories = $accessories->OrderCompany($order);
        //         break;
        //     default:
        //         $accessories = $accessories->orderBy($sort, $order);
        //         break;
        // }

        $sales = $sales->orderBy($sort, $order);
        $sales->orderBy($sort, $order);

        $total = $sales->count();
        $sales = $sales->skip($offset)->take($limit)->get();
        return (new SalesTransformer)->transformSales($sales, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Sale::class);
        $sale = new Sale;
        $sale->fill($request->all());

        if ($sale->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $sale, trans('admin/sales/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $sale->getErrors()));

    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @author [A. Gianotto] [<snipe@snipe.net>]
    //  * @since [v4.0]
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $this->authorize('view', Accessory::class);
    //     $accessory = Accessory::findOrFail($id);
    //     return (new AccessoriesTransformer)->transformAccessory($accessory);
    // }


    // /**
    //  * Display the specified resource.
    //  *
    //  * @author [A. Gianotto] [<snipe@snipe.net>]
    //  * @since [v4.0]
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function accessory_detail($id)
    // {
    //     $this->authorize('view', Accessory::class);
    //     $accessory = Accessory::findOrFail($id);
    //     return (new AccessoriesTransformer)->transformAccessory($accessory);
    // }


    // /**
    //  * Display the specified resource.
    //  *
    //  * @author [A. Gianotto] [<snipe@snipe.net>]
    //  * @since [v4.0]
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function checkedout($id)
    // {
    //     $this->authorize('view', Accessory::class);

    //     $accessory = Accessory::findOrFail($id);
    //     if (!Company::isCurrentUserHasAccess($accessory)) {
    //         return ['total' => 0, 'rows' => []];
    //     }
    //     $accessory_users = $accessory->users;
    //     $total = $accessory_users->count();

    //     return (new AccessoriesTransformer)->transformCheckedoutAccessory($accessory_users, $total);
    // }


    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @author [A. Gianotto] [<snipe@snipe.net>]
    //  * @since [v4.0]
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $this->authorize('edit', Accessory::class);
    //     $accessory = Accessory::findOrFail($id);
    //     $accessory->fill($request->all());

    //     if ($accessory->save()) {
    //         return response()->json(Helper::formatStandardApiResponse('success', $accessory, trans('admin/accessories/message.update.success')));
    //     }

    //     return response()->json(Helper::formatStandardApiResponse('error', null, $accessory->getErrors()));
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @author [A. Gianotto] [<snipe@snipe.net>]
    //  * @since [v4.0]
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $this->authorize('delete', Accessory::class);
    //     $accessory = Accessory::findOrFail($id);
    //     $this->authorize($accessory);

    //     if ($accessory->hasUsers() > 0) {
    //         return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers()))));
    //     }

    //     $accessory->delete();
    //     return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/accessories/message.delete.success')));

    // }
}
