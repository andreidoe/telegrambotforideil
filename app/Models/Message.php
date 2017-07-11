<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram; 

class Message extends Model {

	protected $dateFormat = 'Y-m-d H:i:s';
	public $timestamps = false;

	public function chat() {
		return $this->belongsTo('App\Models\Chat');
	}

	public function setDateAttribute($value) {
		$this->attributes['date'] = date('Y-m-d H:i:s', $value);
	}
}