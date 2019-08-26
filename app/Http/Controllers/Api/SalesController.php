<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Sale;
use App\Http\Transformers\SalesTransformer;
use App\Http\Transformers\SelectlistTransformer;


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

        $offset = (($sales) && (request('offset') > $sales->count())) ? 0 : request('offset', 0);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';



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

    public function selectlist(Request $request)
    {

        $sale = Sale::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $sale = $sale->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $sale = $sale->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($sale);

    }

 
}
