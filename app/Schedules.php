<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
	protected $fillable = [
		'id',
		'name',
		'description',
		'order_pos',
		'resource_ids',
		'permission_ids',
		'created_at',
		'updated_at'
	];
	protected $table = 'schedules';
	protected $primaryKey = 'id';
	public $timestamps = false;//because Unexpected data found when go to url: /sync-resources

}
