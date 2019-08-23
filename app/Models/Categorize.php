<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;
use Watson\Validating\ValidatingTrait;
use App\Http\Traits\UniqueUndeletedTrait;

class Categorize extends Model
{
	use Searchable;
	protected $table = 'categorizes';
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'name',
		'description',
	];
	protected $searchableAttributes = ['name', 'description'];
	protected $searchableRelations = [];
	public $rules = array(
		'name'   => 'required|min:1|max:255|unique_undeleted',
		'description'   => 'required',
	);
	protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;

    public function contract()
    {
        return $this->hasMany('\App\Models\Contract');
    }

}
