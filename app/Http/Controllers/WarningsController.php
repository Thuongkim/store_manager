<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Warning;
use App\Models\Customer;
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

class WarningsController extends Controller
{

	public function index(Request $request)
	{
		$this->authorize('index', Warning::class);
		return view('warnings/index');
	}

    /**
     * Show the form for creating a new Permission.
     *
     * @return Response
     */
    public function create()
    {
    	$this->authorize('create', Warning::class);
    	$customer_type = 'warning';
    	return view('warnings/edit')->with('customer_type', $customer_type)
    	->with('item', new Warning);
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param CreatePermissionRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->authorize(Warning::class);

        // create a new model instance
        $warning = new Warning();
        $customer = Customer::find($request->id_customer);

        // Update the warning data
        isset($customer)?($warning->name = $customer->name):($warning->name = null);
        $warning->id_customer             = request('id_customer');
        isset($customer)?($warning->created_customer_at = $customer->created_at):($warning->created_customer_at = null);
        Carbon::now() >= Carbon::parse($warning->created_customer_at)->addDays(request('duration')) ? $warning->status = "Expired" : $warning->status = "Active";
        $warning->duration                = request('duration');
        $warning->warning_before          = request('warning_before');
        $warning->hour_warning            = request('hour_warning');

        // Was the warning created?
        if ($warning->save()) {
            // Redirect to the new warning page
            return redirect()->route('warnings.index')->with('success', trans('admin/warnings/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($warning->getErrors());
    }

    /**
     * Display the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */

    public function ajax($id)
    {
        $customer = Customer::find($id);
        echo $customer->created_at;
    }

    public function show($warningId = null)
    {
        $warning = Warning::find($warningId);
        if (isset($warning->id)) {
            $this->authorize('view', $warning);
            return redirect()->route('warnings.edit', $warningId);
        }
    }

    /**
     * Show the form for editing the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(Request $request, $warningId = null)
    {
    	if ($item = Warning::find($warningId)) {
    		$this->authorize($item);
    		$customer_type = 'warning';
    		return view('warnings/edit', compact('item'))->with('customer_type', $customer_type);
    	}

    	return redirect()->route('warnings.index')->with('error', trans('admin/warnings/message.does_not_exist'));
    }

    /**
     * Update the specified Permission in storage.
     *
     * @param int $id
     * @param UpdatePermissionRequest $request
     *
     * @return Response
     */
    public function update(Request $request, $warningId = null)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (is_null($warning = Warning::find($warningId))) {
            return redirect()->route('warnings.index')->with('error', trans('admin/warnings/message.does_not_exist'));
        }

        $this->authorize($warning);
        $customer = Customer::find($request->id_customer);

        // Update the warning data
        isset($customer)?($warning->name = $customer->name):($warning->name = null);
        $warning->id_customer             = request('id_customer');
        isset($customer)?($warning->created_customer_at = $customer->created_at):($warning->created_customer_at = null);
        Carbon::now() >= Carbon::parse($warning->created_customer_at)->addDays(request('duration')) ? $warning->status = "Expired" : $warning->status = "Active";
        $warning->duration                = request('duration');
        $warning->warning_before          = request('warning_before');
        $warning->hour_warning            = request('hour_warning');

        // Was the warning updated?
        if ($warning->save()) {
            return redirect()->route('warnings.index')->with('success', trans('admin/warnings/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($warning->getErrors());
    }

    /**
     * Remove the specified Permission from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Request $request, $warningId)
    {
    	if (is_null($warning = Warning::find($warningId))) {
    		return redirect()->route('warnings.index')->with('error', trans('admin/warnings/message.not_found'));
    	}

    	$this->authorize($warning);


        // if ($warning->hasUsers() > 0) {
        //      return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
        // }
    	$warning->delete();
    	return redirect()->route('warnings.index')->with('success', trans('admin/warnings/message.delete.success'));
    }
}
