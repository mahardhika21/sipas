<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
	protected $table = 'employees';

	protected $primarykey = 'id_employees';

	protected $filelable  = ['id_employees','name','company','email','created_at','updated_at'];

	protected $hidden = [];
}