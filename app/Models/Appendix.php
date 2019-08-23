<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;
use Watson\Validating\ValidatingTrait;
use App\Presenters\Presentable;

class Appendix extends Model
{
    protected $table = 'appendixes';

    use Searchable,Presentable;

    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['sign_date',
    	'duartion',
    	'renewed',
    	'value',
    	'payment',
    	'payment_date',];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];

    protected $fillable = [
    	'sign_date',
    	'duartion',
    	'renewed',
    	'value',
    	'payment',
    	'payment_date',
    	'note',
    ];

     /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;

    public $rules = array(
        'sign_date' => 'required',
        'duartion' => 'required',
        'renewed' => 'required',
        'payment' => 'required',
        'payment_date' => 'required',
    );

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }

    public function files()
    {
        return $this->morphMany('App\Models\File', 'fileable');
    }

}