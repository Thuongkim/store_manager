<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Warning;
use App\Http\Transformers\WarningsTransformer;
use App\Helpers\Helper;
use DB;

class WarningsController extends Controller
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
        $this->authorize('index', Warning::class);
        $allowed_columns = ['id', 'id_customer', 'name', 'created_customer_at', 'duration', 'warning_before', 'hour_warning'];

        // $warnings = new Warning(); 
        $warnings = Warning::with('customer');

        if ($request->filled('search')) {
            $warnings = $warnings->TextSearch(e($request->input('search')));
        }
        if ($request->filled('id_customer')) {
            $warnings->where('id_customer', '=', $request->input('id_customer'));
        }

        $offset = (($warnings) && (request('offset') > $warnings->count())) ? 0 : request('offset', 0);
        $limit = request('limit', 100);
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        switch ($sort) {
            case 'customer':
                $warnings = $warnings->OrderCustomer($order);
                break;
            default:
                $warnings = $warnings->orderBy($sort, $order);
                break;
        }

        $warnings = $warnings->orderBy($sort, $order);

        $total = $warnings->count();
        $warnings = $warnings->skip($offset)->take($limit)->get();
        return (new WarningsTransformer)->transformWarnings($warnings, $total);

    }


    public function store(Request $request)
    {
        $this->authorize('create', Warning::class);
        $warning = new Warning;
        $warning->fill($request->all());

        if ($warning->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $warning, trans('admin/warnings/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $warning->getErrors()));
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
        $this->authorize('view', Warning::class);
        $user = Warning::findOrFail($id);
        return (new WarningsTransformer)->transformWarning($warning);
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
        $this->authorize('edit', Warning::class);
        $warning = Warning::findOrFail($id);
        $warning->fill($request->all());

        if ($warning->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $warning, trans('admin/warnings/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $warning->getErrors()));
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
        $this->authorize('delete', Warning::class);
        $warning = Warning::findOrFail($id);
        $this->authorize($warning);

        // if ($warning->hasUsers() > 0) {
        //     return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/warnings/message.assoc_users', array('count'=> $accessory->hasUsers()))));
        // }

        $warning->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/warnings/message.delete.success')));
    }

        /**
    * Returns a JSON response containing details on the users associated with this warning.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see warningsController::getView() method that returns the form.
    * @since [v1.0]
    * @param int $warningId
    * @return array
     */
    public function getDataView($warningId)
    {
        $warning = Warning::with(array('warningAssignments'=>
        function ($query) {
            $query->orderBy($query->getModel()->getTable().'.created_at', 'DESC');
        },
        'warningAssignments.admin'=> function ($query) {
        },
        'warningAssignments.user'=> function ($query) {
        },
        ))->find($warningId);

        if (!Company::isCurrentUserHasAccess($warning)) {
            return ['total' => 0, 'rows' => []];
        }
        $this->authorize('view', warning::class);
        $rows = array();

        foreach ($warning->warningAssignments as $warning_assignment) {
            $rows[] = [
                'name' => ($warning_assignment->user) ? $warning_assignment->user->present()->nameUrl() : 'Deleted User',
                'created_at' => Helper::getFormattedDateObject($warning_assignment->created_at, 'datetime'),
                'admin' => ($warning_assignment->admin) ? $warning_assignment->admin->present()->nameUrl() : '',
            ];
        }

        $warningCount = $warning->users->count();
        $data = array('total' => $warningCount, 'rows' => $rows);
        return $data;
    }
}
