<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckoutAccessoryNotification;

class Warning extends Model
{

    protected $presenter = 'App\Presenters\WarningPresenter';
    use CompanyableTrait;
    use Loggable, Presentable;

    protected $dates = ['deleted_at', 'purchase_date'];
    protected $table = 'warnings';
    protected $casts = [
        'requestable' => 'boolean'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */

    use Searchable;

    protected $searchableAttributes = ['id_customer', 'name', 'created_customer_at', 'duration', 'warning_before', 'hour_warning'];

    protected $searchableRelations = [
        'customer'     => ['name']
    ];

    public static $checkoutClass = CheckoutWarningNotification::class;
    public static $checkinClass = CheckinWarningNotification::class;


    /**
    * Accessory validation rules
    */
    public $rules = array(
        'id_customer'           => 'required|unique|exists:customers,id',
        'name'                  => 'required|min:1|max:255',
        'created_customer_at'   => 'max:255',
        'duration'              => 'required|integer',
        'warning_before'        => 'required|integer|lt:duration',
        'hour_warning'          => 'required'
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
        'id_customer',
        'name',
        'created_customer_at',
        'duration',
        'warning_before',
        'hour_warning'
    ];
    public function numRemaining()
    {
        $checkedout = $this->users->count();
        $total = $this->qty;
        $remaining = $total - $checkedout;
        return $remaining;
    }
    public function scopeOrderCustomer($query, $order)
    {
        return $query->leftJoin('customers', 'warnings.id_customer', '=', 'customers.id')
        ->orderBy('customers.name', $order);
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'id_customer');
    }
}
