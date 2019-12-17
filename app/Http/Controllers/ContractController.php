<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Categorize;
use App\Models\Sale;
use App\Models\User;
use App\Models\File;
use Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contracts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Contract::class);
        $id = Auth::user()->id;
        // dd($id);
        $files = File::where('fileable_id', null)->where('user_id', $id)->get();
        // dd($files);
        foreach ($files as $file) {
            $path = public_path().'/images/'.$file->url;
            if (file_exists($path)) {
                unlink($path);
            }
            $file->delete();
        }
        return view('contracts.edit')->with('item', new Contract);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(1);
        $this->authorize('create', Contract::class);
        $contract                = new Contract();
        $contract->number        = $request->input('number');
        $contract->sign_day      = $request->input('sign_day');
        $contract->customer_id   = $request->input('customer_id');
        $contract->categorize_id = $request->input('categorize_id');
        $contract->duration      = $request->input('duration');
        $contract->renewed       = $request->input('renewed') ? $request->input('renewed') : '0';
        $contract->value         = $request->input('value');
        $contract->payment       = $request->input('payment');
        $contract->day_payment   = $request->input('day_payment');
        $contract->note          = $request->input('note');
        $contract->sale_id       = $request->input('sale_id');
        // dd($contract);
        if ($contract->save()) {
            $fileable_id = $contract->id;
            $id = Auth::user()->id;
            File::where('fileable_id', null)->where('user_id', $id)->update(['fileable_id' => $fileable_id]);
            return redirect()->route('contract.index')->with('success', trans('admin/contract/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($contract->getErrors());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize(Contract::class);
        if ($item = Contract::find($id)) {
            $this->authorize($item);
            $id = Auth::user()->id;
            $files = File::where('fileable_id', null)->where('user_id', $id)->get();
            foreach ($files as $file) {
                $path = public_path() . $file->url;
                if (file_exists($path)) {
                    unlink($path);
                }
                $file->delete();
            }
            return view('contracts.edit')->with('item', $item);
        }

        return redirect()->route('contracts.index');
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
        $this->authorize('edit', Contract::class);
        if (is_null($contract = Contract::find($id))) {
            return redirect()->route('contracts.index');
        }
        $this->authorize('edit', Contract::class);
        $contract->number        = $request->input('number');
        $contract->sign_day      = $request->input('sign_day');
        $contract->customer_id   = $request->input('customer_id');
        $contract->categorize_id = $request->input('categorize_id');
        $contract->duration      = $request->input('duration');
        $contract->renewed       = $request->input('renewed');
        $contract->value         = $request->input('value');
        $contract->payment       = $request->input('payment');
        $contract->day_payment   = $request->input('day_payment');
        $contract->note          = $request->input('note');
        $contract->sale_id       = $request->input('sale_id');
        if ($contract->save()) {
            $fileable_id = $contract->id;
            $id = Auth::user()->id;
            File::where('fileable_id', null)->where('user_id', $id)->update(['fileable_id' => $fileable_id]);
            return redirect()->route('contract.index')->with('success', trans('admin/contract/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($contract->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($contract = Contract::find($id))) {
            return redirect()->route('contracts.index')->with('error', trans('admin/contracts/message.does_not_exist'));
        }

        $this->authorize($contract);
        $files = File::where('fileable_id', $id)->get();
            foreach ($files as $file) {
                $path = public_path() . $file->url;
                if (file_exists($path)) {
                    Storage::delete($file->url);
                }
                $file->delete();
            }
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', trans('admin/contracts/message.update.success'));
    }

}
