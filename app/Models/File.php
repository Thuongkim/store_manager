<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $table = 'files';

	protected $fillable = ['url','user_id','fileable_id','fillable_type'];

	public function filetable()
	{
		return $this->morphTo();
	}
	
	// public static function rules($id = 0) {
 //        return [
 //            'src' => ($id == 0 ? 'required|' : '') . 'max:2048|mimes:jpg,jpeg,png,gif'
 //        ];

 //    }
}
