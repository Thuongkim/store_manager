<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\ContractsTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Contract;
use App\Http\Transformers\SelectlistContractTransformer;

class ContractsController extends Controller
{
    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $contracts = Contract::select([
            'contracts.id',
            'contracts.number',
        ]);

        $contracts = $contracts->orderBy('number', 'ASC')->paginate(50);

        return (new SelectlistContractTransformer)->transformSelectlist($contracts);
    }
}
