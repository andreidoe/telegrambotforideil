<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

	public $timestamps = false;
	
	public function messages() {
		return $this->hasMany('App\Models\Message');
	}
}