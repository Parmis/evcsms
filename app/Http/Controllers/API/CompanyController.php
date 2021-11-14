<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CompanyResource;
use DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Companies = Company::all();
        $_s = array();
        foreach($Companies as $company)
        {
            $company->stations = $this->stationCount($company->id);
            $_s[] = $company;
        }
        return response([ 'company' => $_s, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'parent_company_id' => 'required',
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $company = Company::create($data);

        return response(['company' => new CompanyResource($company), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        // foreach(new CompanyResource($company) as $ad)
        // {
        //     dd($ad);
        // }
        return response(['company' => new CompanyResource($company), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return response(['company' => new CompanyResource($company), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response(['message' => 'Deleted']);
    }
    public function stationCount($stationID)
    {
        $stationInCompany = DB::select("SELECT GROUP_CONCAT(id) as IDS FROM
            (SELECT id,name,parent_company_id,
                    CASE WHEN id = ".$stationID." THEN @idlist := CONCAT(id)
                         WHEN FIND_IN_SET(parent_company_id,@idlist) THEN @idlist := CONCAT(@idlist,',',id)
                    END as checkId
             FROM companies
             ORDER BY id ASC) as T
        WHERE checkId IS NOT NULL");
         
         $counter = DB::select('select count(*) as stationCount from `stations` where `company_id` in ('.$stationInCompany[0]->IDS.')');
         
            return $counter[0]->stationCount;
            
    }
}
