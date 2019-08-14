<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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

class CustomersController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('index', Customer::class);
        return view('customers/index');
    }

    /**
     * Show the form for creating a new Permission.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Customer::class);
        $category_type = 'customer';
        return view('customers/edit')->with('category_type', $category_type)
          ->with('item', new Customer);
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
        $this->authorize(Customer::class);
        
        $customer = new Customer();

        $customer->name                    = request('name');
        $customer->phone                   = request('phone');
        $customer->address                 = request('address');
        $customer->city                    = request('city');
        $customer->state                   = request('state');
        $customer->country                 = request('country');
        $customer->zip                     = request('zip');
        $customer->taxcode                 = request('taxcode');
        $customer->email                   = request('email');

        if ($customer->save()) {
            return redirect()->route('customers.index')->with('success', trans('admin/customers/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($customer->getErrors());
    }

    /**
     * Display the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($customerId = null)
    {
        if(!$customer = Customer::find($customerId)) {
            $error = trans('admin/customers/message.customer_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('customers.index')->with('error', $error);
        }

        //$customerlog = $customer->customerlog->load('item');

        if (isset($customer->id)) {
            $this->authorize('view', $customer);
            return view('customers/view', compact('customer'));
        }
    }

    /**
     * Show the form for editing the specified Permission.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(Request $request, $customerId = null)
    {
        if ($item = Customer::find($customerId)) {
            $this->authorize($item);
            $category_type = 'customer';
            return view('customers/edit', compact('item'))->with('category_type', $category_type);
        }

        return redirect()->route('customers.index')->with('error', trans('admin/customers/message.does_not_exist'));
    }

    /**
     * Update the specified Permission in storage.
     *
     * @param int $id
     * @param UpdatePermissionRequest $request
     *
     * @return Response
     */
    public function update(Request $request, $customerId = null)
    {
        if (is_null($customer = Customer::find($customerId))) {
            return redirect()->route('customers.index')->with('error', trans('admin/customers/message.does_not_exist'));
        }

        $this->authorize($customer);

        // Update the accessory data
        $customer->name                    = request('name');
        $customer->phone                   = request('phone');
        $customer->address                 = request('address');
        $customer->city                    = request('city');
        $customer->state                   = request('state');
        $customer->country                 = request('country');
        $customer->zip                     = request('zip');
        $customer->taxcode                 = request('taxcode');
        $customer->email                   = request('email');

        // Was the accessory updated?
        if ($customer->save()) {
            return redirect()->route('customers.index')->with('success', trans('admin/customers/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($customer->getErrors());
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
    public function destroy(Request $request, $customerId)
    {
        if (is_null($customer = Customer::find($customerId))) {
            return redirect()->route('customers.index')->with('error', trans('admin/customers/message.not_found'));
        }

        $this->authorize($customer);


        // if ($customer->hasUsers() > 0) {
        //      return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
        // }
        $customer->delete();
        return redirect()->route('customers.index')->with('success', trans('admin/customers/message.delete.success'));
    }
}
