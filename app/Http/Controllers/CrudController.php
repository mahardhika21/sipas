<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\Companies;
use App\Model\Employees;
use App\Helpers\ValidateRule;

class CrudController extends Controller
{
	private $rule;

	public function __construct()
	{
		$this->rule = new ValidateRule();
	}

	public function companies_view(Request $request)
	{

			// $this->rule->coba();
			// die();
		    $data  = array
		    			(	
		    				"companies" => Companies::paginate(5),
		    			);

			return view('companies', $data);
	}


	public function employees_view(Request $request)
	{
		 $sql = Employees::select('employees.*','companies.name as company_name')
		 		->leftJoin('companies','Employees.company','=','companies.id_companies')
		 		->paginate(5);
		$data = array
					(
						"companies" => Companies::get(),
						"employees" => $sql,
					);

		return view('employees', $data);
	}



	// operation

	public function crudCompanies(Request $request, $type)
	{
		if($type == "insert")
		{

			$validator = validator::make($request->all(),$this->rule->ruleCompanies(array('type' => 'insert')), $this->rule->messageRuleCompanies(array('type' => 'insert')));

			if($validator->fails())
			{
				$errors = $validator->messages()->first();

						$resp["success"]  = 'false';
						$resp["code"]     = 'danger';
						$resp["message"]  = $errors;

				return redirect('companies')->with(['msg' => $resp]);
			}

			DB::beginTransaction();
			try
			{
				$file = $request->file('logo');

				$fname = strtotime(date('Y-m-d H:i:s')).'.'.$file->getClientOriginalExtension();
				Storage::disk('logo_img')->put($fname, file_get_contents($file->getRealPath()));

				$arr_data = array
								(
									"name"    => $request->input('name'),
									"email"   => $request->input('email'),
									"website" => $request->input('website'),
									"logo"    => $fname,
								);
				Companies::insert($arr_data);

				$resp["success"]  = 'true';
				$resp["code"]     = 'success';
				$resp["message"]  = 'success insert data';

				DB::commit();


			}
			catch(\Illuminate\Database\QueryException $e)
			{

				$resp["success"]  = 'false';
				$resp["code"]     = 'danger';
				$resp["message"]  = $e->getMessage();
			}


		 return redirect('companies')->with(['msg' => $resp]);


		}
		elseif($type == "update")
		{

			$stat = $request->input('status_up_logo');

			if($stat == 'true')
			{
					$validator = validator::make($request->all(),$this->rule->ruleCompanies(array('type' => 'update', 'img' => true)), $this->rule->messageRuleCompanies(array('type' => 'update', 'img' => true)));
			}
			else
			{
					$validator = validator::make($request->all(),$this->rule->ruleCompanies(array('type' => 'update', 'img' => false)), $this->rule->messageRuleCompanies(array('type' => 'update', 'img' => false)));
			}


			if($validator->fails())
			{
				$errors = $validator->messages()->first();

						$resp["success"]  = 'false';
						$resp["code"]     = 'danger';
						$resp["message"]  = $errors;

				return redirect('companies')->with(['msg' => $resp]);
			}


			DB::beginTransaction();

			try
			{
				$id = $request->input('id_companies');
				$company = Companies::where('id_companies', $id)->get();
				if($stat == 'true')
				{
					$file = $request->file('logo');

					$fname = strtotime(date('Y-m-d H:i:s')).'.'.$file->getClientOriginalExtension();
					Storage::disk('logo_img')->put($fname, file_get_contents($file->getRealPath()));

					Storage::disk('logo_img')->delete($company[0]->logo);
				     $arr_data = array
								(
									"name"    => $request->input('name'),
									"email"   => $request->input('email'),
									"website" => $request->input('website'),
									"logo"    => $fname,
								);
				      Companies::where('id_companies', $id)->update($arr_data);
				}
				else
				{
					$arr_data = array
									(
										"name"  	=> $request->input('name'),
										"email" 	=> $request->input('email'),
										"website"	=> $request->input('website'),
									);
					Companies::where('id_companies', $id)->update($arr_data);
				}

				DB::commit();

				$resp["success"]  = 'true';
				$resp["code"]     = 'success';
				$resp["message"]  = 'success update data';

			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp["success"]  = 'false';
				$resp["code"]     = 'danger';
				$resp["message"]  = $e->getMessage();	
			}

			return redirect('companies')->with(['msg' => $resp]);

		}
		elseif($type == "get")
		{
			$id = $request->input('id');

			if(empty($id))
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'get data galat, id cannot by null';

				return response()->json($resp, 200);
			}

			DB::beginTransaction();

			try
			{
				$data = Companies::where('id_companies',$id)->get();

				$resp['success']  = 'true';
				$resp['code']     = 'success';
				$resp['data']	  =  $data;
				$resp['message']  = 'success get data';

				DB::commit();
			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = $e->getMessage();	
			}

			return response()->json($resp, 200);

		}
		elseif($type == 'delete')
		{
			$id = $request->input('id');

			if(empty($id))
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'delete data galat, id cannot by null';

				return response()->json($resp, 200);
			}

			$company = Companies::where('id_companies', $id)->get();

			if(count($company)<0)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'data not exits';

				return response()->json($resp, 200);
			}

			DB::beginTransaction();

			try
			{
				$data = Companies::where('id_companies',$id)->delete();
				Storage::disk('logo_img')->delete($company[0]->logo);
				
				$resp['success']  = 'true';
				$resp['code']     = 'success';
				$resp['data']	  =  $data;
				$resp['message']  = 'success delete data';

				DB::commit();
			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = $e->getMessage();	
			}

			return response()->json($resp, 200);
		}
	}



	// emploeyess crud

	public function crudEmployees(Request $request, $type)
	{
		if($type == "insert")
		{

			$validator = validator::make($request->all(),$this->rule->ruleEmployess('insert'), $this->rule->messageRuleEmployess('insert'));

			if($validator->fails())
			{
				$errors = $validator->messages()->first();

						$resp["success"]  = 'false';
						$resp["code"]     = 'danger';
						$resp["message"]  = $errors;

				return redirect('employees')->with(['msg' => $resp]);
			}

			DB::beginTransaction();
			try
			{
				

				$arr_data = array
								(
									"name"    => $request->input('name'),
									"email"   => $request->input('email'),
									"company" => $request->input('company'),
								);
				Employees::insert($arr_data);

				$resp["success"]  = 'true';
				$resp["code"]     = 'success';
				$resp["message"]  = 'success insert data';

				DB::commit();


			}
			catch(\Illuminate\Database\QueryException $e)
			{

				$resp["success"]  = 'false';
				$resp["code"]     = 'danger';
				$resp["message"]  = $e->getMessage();
			}


		 return redirect('employees')->with(['msg' => $resp]);


		}
		elseif($type == "update")
		{
			$validator = validator::make($request->all(),$this->rule->ruleEmployess('update'), $this->rule->messageRuleEmployess('update'));

			if($validator->fails())
			{
				$errors = $validator->messages()->first();

						$resp["success"]  = 'false';
						$resp["code"]     = 'danger';
						$resp["message"]  = $errors;

				return redirect('employees')->with(['msg' => $resp]);
			}

			DB::beginTransaction();

			try
			{
				$id = $request->input('id_employees');

				$arr_data = array
								(
									"name"    => $request->input('name'),
									"email"   => $request->input('email'),
									"company" => $request->input('company'),
								);
				Employees::where('id_employees', $id)->update($arr_data);

				        $resp["success"]  = 'true';
						$resp["code"]     = 'success';
						$resp["message"]  = 'success update data';

				DB::commit();

			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp["success"]  = 'false';
				$resp["code"]     = 'danger';
				$resp["message"]  = $e->getMessage();
			}

			return redirect('employees')->with(['msg' => $resp]);
		}
		elseif($type == "get")
		{
			$id = $request->input('id');

			if(empty($id))
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'get data galat, id cannot by null';

				return response()->json($resp, 200);
			}

			DB::beginTransaction();

			try
			{
				$data = Employees::select('employees.*','companies.name as company_name')
		 				->leftJoin('companies','Employees.company','=','companies.id_companies')
		 				->where('employees.id_employees', $id)
		 				->get();
				

				$resp['success']  = 'true';
				$resp['code']     = 'success';
				$resp['data']	  =  $data;
				$resp['message']  = 'success get data';

				DB::commit();
			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = $e->getMessage();	
			}

			return response()->json($resp, 200);

		}
		elseif($type == 'delete')
		{
			$id = $request->input('id');

			if(empty($id))
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'delete data galat, id cannot by null';

				return response()->json($resp, 200);
			}

			if(count(Employees::where('id_employees', $id)->get())<0)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = 'data not exits';

				return response()->json($resp, 200);
			}

			DB::beginTransaction();

			try
			{
				$data = Employees::where('id_employees',$id)->delete();

				$resp['success']  = 'true';
				$resp['code']     = 'success';
				$resp['data']	  =  $data;
				$resp['message']  = 'success delete data';

				DB::commit();
			}
			catch(\Illuminate\Database\QueryException $e)
			{
				$resp['success'] = 'false';
				$resp['code']    = 'danger';
				$resp['message'] = $e->getMessage();	
			}

			return response()->json($resp, 200);
		}
	}
}
