<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Contract;
use App\Http\Transformers\ContractTransformer;
use App\Http\Transformers\SelectlistTransformer;
use DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(1);
        $this->authorize('view', Contract::class);

        $allowed_columns = ['id','number','sign_day','customer_id','categorize_id','duration','renewed','value','payment','day_payment','note','sale_id'];
        // dd($allowed_columns);

        $contract = Contract::select(['id','number','sign_day','customer_id','categorize_id','duration','renewed','value','payment','day_payment','note','sale_id']);
        // dd($contract);


        if ($request->filled('search')) {
            $contract = $contract->TextSearch($request->input('search'));
        }

        $offset = (($contract) && (request('offset') > $contract->count())) ? 0 : request('offset', 0);
        // dd($offset);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        // dd($order);
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'id';
        // dd($sort);
        $contract->orderBy($sort, $order);

        $total = $contract->count();
        $contract = $contract->skip($offset)->take($limit)->get();
        // dd($contract);
        return (new ContractTransformer)->transformContract($contract, $total);
    }
    public function selectlist(Request $request)
    {

        $contract = Contract::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $contract = $contract->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $contract = $contract->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($contract);

    }

    
}
