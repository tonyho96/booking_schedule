<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{

	protected $fillable = [
							'id',
							'name',
							'description',
							'type_id',
							'parent_id',
							'order_pos'
						];
    protected $table = 'resources';
    protected $primaryKey = 'id';
	public $timestamps = false;


}
