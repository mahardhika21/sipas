<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
	protected $table = "companies";

	protected $primarykey = "id_companies";

	protected $filelable = ['id_companies','name','email','logo','website','created_at','updated_at'];

	protected $hidden =[];
}