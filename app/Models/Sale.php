<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;
use Watson\Validating\ValidatingTrait;
use App\Presenters\Presentable;

class Sale extends Model
{
    protected $table = 'sales';

    use Searchable,Presentable;

    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'email', 'phone', 'address','gender'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];

    protected $fillable = [
    	'name',
    	'email',
    	'phone',
    	'address',
    	'gender'
    ];

    // public static function rules()
    // {
    // 	return [
    //         'email' => 'required|max:50|min:10|email|unique:sales,email',
    //         'name' => 'required|max:50',
    //         'phone' => 'required|max:13',
    //         'address' => 'required|max:100',
    //         'gender' => 'required'            
    //     ];
    // }
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
        'email' => 'required|max:50|min:10|email|unique_undeleted',
        'name' => 'required|max:50',
        'phone' => 'required|max:13|unique_undeleted',
        'address' => 'required|max:100',
        'gender' => 'required'
    );

    public function contract()
    {
        return $this->hasOne('\App\Models\Contract');
    }

}
