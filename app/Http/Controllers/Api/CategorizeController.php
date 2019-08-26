<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Categorize;
use App\Http\Transformers\CategorizeTransformer;
use App\Http\Transformers\SelectlistTransformer;
use DB;

class CategorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Categorize::class);

        $allowed_columns = ['id', 'name', 'description'];
        // dd($allowed_columns);

        $categorize = Categorize::select(['id', 'created_at', 'updated_at', 'name','description']);
        // dd($categorize);


        if ($request->filled('search')) {
            $categorize = $categorize->TextSearch($request->input('search'));
        }

        $offset = (($categorize) && (request('offset') > $categorize->count())) ? 0 : request('offset', 0);
        // dd($offset);
        $limit = $request->input('limit', 50);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        // dd($order);
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'id';
        // dd($sort);
        $categorize->orderBy($sort, $order);

        $total = $categorize->count();
        $categorize = $categorize->skip($offset)->take($limit)->get();
        return (new CategorizeTransformer)->transformCategorize($categorize, $total);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('view', Categorize::class);
        return view('categorize.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('view', Categorize::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Categorize::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('view', Categorize::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('view', Categorize::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('view', Categorize::class);
    }

     public function selectlist(Request $request)
    {

        $categorize = Categorize::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $categorize = $categorize->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $categorize = $categorize->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($categorize);

    }


}
