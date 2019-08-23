<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Company;
use App\Http\Transformers\CustomersTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Helpers\Helper;
use DB;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', Customer::class);
         $customers = new Customer();        

        if ($request->filled('search')) {
            $customers = $customers->TextSearch(e($request->input('search')));
        }

        // if ($request->filled('company_id')) {
        //     $customers->where('company_id','=',$request->input('company_id'));
        // }

        // if ($request->filled('category_id')) {
        //     $customers->where('category_id','=',$request->input('category_id'));
        // }

        // if ($request->filled('manufacturer_id')) {
        //     $customers->where('manufacturer_id','=',$request->input('manufacturer_id'));
        // }


        $offset = (($customers) && (request('offset') > $customers->count())) ? 0 : request('offset', 0);
        $limit = request('limit', 100);
        $allowed_columns = ['id','name','phone','address','city','state','country','zip','taxcode','email'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';


        // switch ($sort) {
        //     case 'category':
        //         $customers = $customers->OrderCategory($order);
        //         break;
        //     case 'location':
        //         $customers = $customers->OrderLocation($order);
        //         break;
        //     case 'manufacturer':
        //         $customers = $customers->OrderManufacturer($order);
        //         break;
        //     case 'company':
        //         $customers = $customers->OrderCompany($order);
        //         break;
        //     default:
        //         $customers = $customers->orderBy($sort, $order);
        //         break;
        // }

        $customers = $customers->orderBy($sort, $order);

        $total = $customers->count();
        $customers = $customers->skip($offset)->take($limit)->get();
        return (new CustomersTransformer)->transformCustomers($customers, $total);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', customer::class);
        $customer = new customer;
        $customer->fill($request->all());

        if ($customer->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $customer, trans('admin/customers/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $customer->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Customer::class);
        $user = Customer::findOrFail($id);
        return (new CustomersTransformer)->transformCustomer($customer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', Customer::class);
        $customer = Customer::findOrFail($id);
        $customer->fill($request->all());

        if ($customer->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $customer, trans('admin/customers/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $customer->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Customer::class);
        $customer = Customer::findOrFail($id);
        $this->authorize($customer);

        // if ($customer->hasUsers() > 0) {
        //     return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/customers/message.assoc_users', array('count'=> $accessory->hasUsers()))));
        // }

        $customer->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/customers/message.delete.success')));
    }

        /**
    * Returns a JSON response containing details on the users associated with this customer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see customersController::getView() method that returns the form.
    * @since [v1.0]
    * @param int $customerId
    * @return array
     */
    public function getDataView($customerId)
    {
        $customer = customer::with(array('customerAssignments'=>
        function ($query) {
            $query->orderBy($query->getModel()->getTable().'.created_at', 'DESC');
        },
        'customerAssignments.admin'=> function ($query) {
        },
        'customerAssignments.user'=> function ($query) {
        },
        ))->find($customerId);

        if (!Company::isCurrentUserHasAccess($customer)) {
            return ['total' => 0, 'rows' => []];
        }
        $this->authorize('view', customer::class);
        $rows = array();

        foreach ($customer->customerAssignments as $customer_assignment) {
            $rows[] = [
                'name' => ($customer_assignment->user) ? $customer_assignment->user->present()->nameUrl() : 'Deleted User',
                'created_at' => Helper::getFormattedDateObject($customer_assignment->created_at, 'datetime'),
                'admin' => ($customer_assignment->admin) ? $customer_assignment->admin->present()->nameUrl() : '',
            ];
        }

        $customerCount = $customer->users->count();
        $data = array('total' => $customerCount, 'rows' => $rows);
        return $data;
    }

    public function selectlist(Request $request)
    {

        $customer = Customer::select([
            'id',
            'name',
        ]);

        if ($request->filled('search')) {
            $customer = $customer->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $customer = $customer->orderBy('name', 'ASC')->paginate(50);

        return (new SelectlistTransformer)->transformSelectlist($customer);

    }
}
