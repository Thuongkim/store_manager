<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Helpers\Helper;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Input;
use Lang;
use Redirect;
use Illuminate\Http\Request;
use Slack;
use Str;
use View;
use Image;
use App\Http\Requests\ImageUploadRequest;

class SalesControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Sale::class);
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Sale::class);
        return view('sales.edit')->with('item', new Sale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize(Sale::class);
        $sale          = new Sale();
        $sale->name    = request('name');
        $sale->email   = request('email');
        $sale->phone   = request('phone');
        $sale->address = request('address');
        $sale->gender  = request('gender');

        // Was the sale created?
        if ($sale->save()) {
            // Redirect to the new sale  page
            return redirect()->route('sales.index')->with('success', trans('admin/sales/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($sale->getErrors());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        $this->authorize($sale);
        if (isset($sale)) {
            return view('sales.view')->with('sale', $sale);
        }

        return redirect()->route('sales.index')->with('error', trans('admin/sales/message.does_not_exist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($item = Sale::find($id)) {
            $this->authorize($item);
            return view('sales.edit')->with('item', $item);
        }

        return redirect()->route('sales.index')->with('error', trans('admin/sales/message.does_not_exist'));
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
        if (is_null($sale = Sale::find($id))) {
            return redirect()->route('sales.index')->with('error', trans('admin/sales/message.does_not_exist'));
        }

        $this->authorize($sale);
        $sale->name    = request('name');
        $sale->email   = request('email');
        $sale->phone   = request('phone');
        $sale->address = request('address');
        $sale->gender  = request('gender');

        // Was the sale created?
        if ($sale->save()) {
            // Redirect to the new sale  page
            return redirect()->route('sales.index')->with('success', trans('admin/sales/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($sale->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($sale = Sale::find($id))) {
            return redirect()->route('sales.index')->with('error', trans('admin/sales/message.does_not_exist'));
        }

        $this->authorize($sale);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', trans('admin/sales/message.update.success'));
    }
}
