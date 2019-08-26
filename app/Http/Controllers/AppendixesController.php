<?php

namespace App\Http\Controllers;

use App\Models\Appendix;
use App\Models\File;
use App\Models\Contract;
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
use Illuminate\Support\Facades\Storage;

class AppendixesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Appendix::class);
        return view('appendixes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Appendix::class);
        //delete image when fileable_id = null
        $id = Auth::user()->id;
        $files = File::where('fileable_id', null)->where('user_id', $id)->get();
        foreach ($files as $file) {
            $path = public_path() . $file->url;
            if (file_exists($path)) {
                Storage::delete($file->url);
            }
            $file->delete();
        }
        return view('appendixes.edit')->with('item', new Appendix);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize(Appendix::class);
        // create a new model instance
        $appendix = new Appendix();

        // Update the appendix data
        $appendix->sign_date    = request('sign_date');
        $appendix->duration     = request('duration');
        $appendix->renewed = (request('renewed'))  ? request('renewed') : '0';
        $appendix->value        = Helper::ParseFloat(request('value'));        
        $appendix->contract_id  = request('contract_id');
        $appendix->payment      = request('payment');
        $appendix->payment_date = request('payment_date');
        $appendix->note = request('note');

        // if ($request->hasFile('image')) {

        //     if (!config('app.lock_passwords')) {
        //         $image = $request->file('image');
        //         $ext = $image->getClientOriginalExtension();
        //         $file_name = "appendix-".str_random(18).'.'.$ext;
        //         $path = public_path('/uploads/appendixes');
        //         if ($image->getClientOriginalExtension()!='svg') {
        //             Image::make($image->getRealPath())->resize(null, 800, function ($constraint) {
        //                 $constraint->aspectRatio();
        //                 $constraint->upsize();
        //             })->save($path.'/'.$file_name);
        //         } else {
        //             $image->move($path, $file_name);
        //         }
        //         $appendix->image = $file_name;
        //     }
        // }



        // Was the appendix created?
        if ($appendix->save()) {
            //save fileable_id for image
            $fileable_id = $appendix->id;
            $id = Auth::user()->id;
            File::where('fileable_id', null)->where('user_id', $id)->update(['fileable_id' => $fileable_id]);
            
            // Redirect to the new appendix  page
            return redirect()->route('appendixes.index')->with('success', trans('admin/appendixes/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($appendix->getErrors());
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
        if ($item = Appendix::find($id)) {
            $this->authorize($item);
            //delete image when fileable_id = null
            $id = Auth::user()->id;
            $files = File::where('fileable_id', null)->where('user_id', $id)->get();
            foreach ($files as $file) {
                $path = public_path() . $file->url;
                if (file_exists($path)) {
                    Storage::delete($file->url);
                }
                $file->delete();
            }
            return view('appendixes.edit')->with('item', $item);
        }

        return redirect()->route('appendixes.index')->with('error', trans('admin/appendixes/message.does_not_exist'));
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
        if (is_null($appendix = Appendix::find($id))) {
            return redirect()->route('appendixes.index')->with('error', trans('admin/appendixes/message.does_not_exist'));
        }
        $this->authorize(Appendix::class);

        // Update the appendix data
        $appendix->sign_date    = request('sign_date');
        $appendix->duration     = request('duration');
        $appendix->renewed = (request('renewed'))  ? request('renewed') : '0';
        $appendix->value        = Helper::ParseFloat(request('value'));        
        $appendix->contract_id  = request('contract_id');
        $appendix->payment      = request('payment');
        $appendix->payment_date = request('payment_date');
        $appendix->note = request('note');

        // Was the appendix updated?
        if ($appendix->save()) {
            //save fileable_id for image
            $fileable_id = $appendix->id;
            $id = Auth::user()->id;
            File::where('fileable_id', null)->where('user_id', $id)->update(['fileable_id' => $fileable_id]);
            // Redirect to the new appendix  page
            return redirect()->route('appendixes.index')->with('success', trans('admin/appendixes/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($appendix->getErrors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($appendix = Appendix::find($id))) {
            return redirect()->route('appendixes.index')->with('error', trans('admin/appendixes/message.does_not_exist'));
        }

        $this->authorize($appendix);
        $files = File::where('fileable_id', $id)->get();
            foreach ($files as $file) {
                $path = public_path() . $file->url;
                if (file_exists($path)) {
                    Storage::delete($file->url);
                }
                $file->delete();
            }
        $appendix->delete();
        return redirect()->route('appendixes.index')->with('success', trans('admin/appendixes/message.update.success'));
    }
}
