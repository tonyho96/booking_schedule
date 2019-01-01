<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id',
    	'name',
		'code',
		'description',
		'status_id',
		'start_timestamp',
		'end_timestamp',
		'private',
        'parent_folder_id',
		'client_person_id',
		'client_organization_id',
		'project_order',
		'color_background',
        'color_text',
		'created_id',
		'created',
		'updated_id',
		'updated'
	];
	public $timestamps = false;

    
}
