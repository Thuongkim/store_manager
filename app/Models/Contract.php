<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\Presentable;
use App\Models\Traits\Searchable;
use Watson\Validating\ValidatingTrait;
use App\Http\Traits\UniqueUndeletedTrait;

class Contract extends Model
{
	protected $presenter = 'App\Presenters\ContractPresenter';
    use Searchable;
    use CompanyableTrait;
    use Loggable, Presentable;
    use UniqueUndeletedTrait;
	protected $table = 'contracts';
	protected $fillable = [
		'number',
		'sign_day',
		'customer_id',
		'categorize_id',
		'duration',
		'renewed',
		'value',
		'payment',
		'day_payment',
		'note',
		'sale_id'
	];
	use ValidatingTrait;
	public $rules = array(
		'number'        =>'required',
		// 'sign_date'      =>'required',
		'customer_id'   =>'required',
		'categorize_id' =>'required',
		'duration'      =>'required',
		'value'         =>'required',
		'payment'       =>'required',
		'day_payment'   =>'required',
		'sale_id'       =>'required'
	);
	protected $searchableAttributes = ['number', 'value', 'payment','duration', 'renewed'];
	protected $searchableRelations = [
		'customer'   => ['name'],
		'categorize' => ['name'],
		'sale'       => ['name']
	];
	protected $injectUniqueIdentifier = true;
    
    public function customer()
    {
        return $this->belongsTo('\App\Models\Customer', 'customer_id');
    }
    public function categorize()
    {
        return $this->belongsTo('\App\Models\Categorize', 'categorize_id');
    }
    public function sale()
    {
        return $this->belongsTo('\App\Models\Sale', 'sale_id');
    }
    public function appendix()
    {
        return $this->hasMany('\App\Models\Appendix');
    }
    public function appendixes()
    {
        return $this->hasMany('App\Models\Appendix');
    }
    public function files()
	{
		return $this->morphMany('\App\Models\File', 'fileable');
	}
}
