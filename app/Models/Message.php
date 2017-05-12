<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	protected $dateFormat = 'Y-m-d H:i:s';
	public $timestamps = false;

	public function chat() {
		return $this->belongsTo('App\Models\Chat', 'foreign_key');
	}

}