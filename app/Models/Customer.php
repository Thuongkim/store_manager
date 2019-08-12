<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckoutAccessoryNotification;

class Customer extends Model
{

    protected $presenter = 'App\Presenters\CustomerPresenter';
    use CompanyableTrait;
    use Loggable, Presentable;

    protected $dates = ['deleted_at', 'purchase_date'];
    protected $table = 'customers';
    protected $casts = [
        'requestable' => 'boolean'
    ];

    use Searchable;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'phone', 'address', 'city', 'state', 'country', 'zip', 'taxcode', 'email'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    // protected $searchableRelations = [
    //     'category'     => ['name'],
    //     'company'      => ['name'],
    //     'manufacturer' => ['name'],
    //     'supplier'     => ['name'],
    //     'location'     => ['name']
    // ];
   
    /**
     * Set static properties to determine which checkout/checkin handlers we should use
     */
    public static $checkoutClass = CheckoutCustomerNotification::class;
    public static $checkinClass = CheckinCustomerNotification::class;


    /**
    * Accessory validation rules
    */
    public $rules = array(
        'name'              => 'required|min:3|max:255',
        'phone'             => 'required|min:3|max:255',
        'address'           => 'required|min:3|max:255',
        'city'              => 'required|min:3|max:255',
        'state'             => 'required|min:3|max:255',
        'country'           => 'required|min:1|max:255',
        'zip'               => 'required|min:3|max:255',
        'taxcode'           => 'required|min:3|max:255',
        'email'             => 'required|min:3|max:255',
    );


    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip',
        'taxcode',
        'email'
    ];
    public function numRemaining()
    {
        $checkedout = $this->users->count();
        $total = $this->qty;
        $remaining = $total - $checkedout;
        return $remaining;
    }
}
