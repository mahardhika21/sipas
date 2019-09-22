<?php

namespace App\Helpers;

class ValidateRule 
{
	public function ruleCompanies($dt)
	{
			if($dt['type'] == "insert")
			{
				$rules = array
							(
								"name"     => "required",
								"email"    => "required|email",
								"website"  => "required",
								"logo"     => "required|dimensions:min_width=100,min_height=100|mimes:png|max:2048",
							);
			}
			else if($dt['type'] == 'update')
			{
					if($dt['img'] ==  true)
					{
						$rules = array
							(
								"name"     => "required",
								"email"    => "required|email",
								"website"  => "required",
								"logo"     => "required|dimensions:min_width=100,min_height=200|mimes:png|max:2048",
							);
						}else
						{
							$rules = array
							(
								"name"     => "required",
								"email"    => "required|email",
								"website"  => "required",
							);
						}
			}

			return $rules;
	}


	public function ruleEmployess($type)
	{

		  if($type == "insert")
		  {
		  		$rules = array
							(
								"name"     => "required",
								"company"  => "required",
								"email"    => "required|email",
							
							);
		  }
		  elseif($type == 'update')
		  {
		  		$rules = array
							(
								"id_employees" => "required",
								"name"     	   => "required",
								"company"  	   => "required",
								"email"        => "required|email",
							
							);
		  }
			

			return $rules;
	}


	public function messageRuleCompanies($dt)
	{
		if($dt['type'] == "insert")
			{
				$message = array
							(
								"name.required"     => "nama perusahaan wajib di isi",
								"email.required"    => "email wajib di isi",
								"email.email"       => "format email yang dimasukkan salah",
								"website.required"  => "website wajib di isi",
								"logo.required"     => "logo wajib dimasukkan",
								"logo.dimensions"   => "minimal ukuran logo 100x100 px",
								"logo.mimes"        => "format logo harus png",
								"logo.max"          => "maximal ukuran logo 2 MB",
							);
			}
			else if($dt['type'] == 'update')
			{
					if($dt['img'] ==  true)
					{
						$message = array
							(
								"name.required"     => "nama perusahaan wajib di isi",
								"email.required"    => "email wajib di isi",
								"email.email"       => "format email yang dimasukkan salah",
								"website.required"  => "website wajib di isi",
								"logo.required"     => "logo wajib dimasukkan",
								"logo.dimensions"   => "minimal ukuran logo 100x100 px",
								"logo.mimes"        => "format logo harus png",
								"logo.max"          => "maximal ukuran logo 2 MB",
							);
						}
						else
						{
							$message = array
							(
								"name.required"     => "nama perusahaan wajib di isi",
								"email.required"    => "email wajib di isi",
								"email.email"       => "format email yang dimasukkan salah",
								"website.required"  => "website wajib di isi",
							);
						}
			}

			return $message;
	}


	public function messageRuleEmployess($type)
	{

		if($type == "insert")
		{
			$message = array
							(
								"name.required"     => "nama karyawan wajib di isi",
								"email.required"    => "email karyawan wajib",
								"email.email"       => "format email yang dimasukkan salah",
								"company.required"  => "perusahaan karyawan wajib di isi"
							);
		}
		elseif($type == "update")
		{
			$message = array
							(
								"id_employees.required"   => "id_employees wajib tidak boleh di ksosongkan",
								"name.required"     	  => "nama karyawan wajib di isi",
								"email.required"   		  => "email karyawan wajib",
								"email.email"       	  => "format email yang dimasukkan salah",
								"company.required"  	  => "perusahaan karyawan wajib di isi"
							);
		}
			


			return $message;
	}


	public function coba()
	{
		echo "heloow coba";
	}


}