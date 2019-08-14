<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\Categorize;
use Illuminate\Support\Facades\Gate;

class CategorizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Categorize::class);
        return view('categorize.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Categorize::class);
        return view('categorize.edit')->with('item', new Categorize);
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
        $this->authorize('create', Categorize::class);
        $categorize = new Categorize();
        $categorize->name                 = $request->input('name');
        $categorize->description        = $request->input('description');

        if ($categorize->save()) {
            return redirect()->route('categorize.index')->with('success', trans('admin/categories/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($categorize->getErrors());
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
        return redirect()->route('categorize.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize(Categorize::class);
        if (is_null($item = Categorize::find($id))) {
            return redirect()->route('categorize.index')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        return view('categorize.edit', compact('item'));
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
        $this->authorize('edit', Categorize::class);
        if (is_null($categorize = Categorize::find($id))) {
            return redirect()->to('admin/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        $categorize->name                 = $request->input('name');

        $categorize->description        = $request->input('description');

        if ($categorize->save()) {
            return redirect()->route('categorize.index')->with('success', trans('admin/categories/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($categorize->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Categorize::class);
        $categorize = Categorize::find($id)->delete();
        return redirect()->route('categorize.index')->with('success', trans('admin/categories/message.delete.success'));
    }
}
