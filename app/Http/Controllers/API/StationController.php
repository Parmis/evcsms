<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StationResource;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Stations = Station::all();
        $_s = array();
        foreach($Stations as $Station)
        {
            $Station->company = Company::where(['id' => $Station->company_id])->first();
            $_s[] = $Station;
        }
        //return response([ 'stations' => $_s, 'message' => 'Retrieved successfully'], 200);
        return response()->json([
            'status' => 200,
            'stations' => $_s,
            'message' => 'Retrieved successfully'
        ]);
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
            'name' => 'required|max:255',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
            'company_id' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Station = Station::create($data);

        return response(['stations' => new StationResource($Station), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function show(Station $station)
    {
        return response(['stations' => new StationResource($station), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Station $station)
    {
        //
        $station->update($request->all());

        return response(['stations' => new StationResource($station), 'message' => 'Update successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Station  $station
     * @return \Illuminate\Http\Response
     */
    public function destroy(Station $station)
    {
        $station->delete();

        return response(['message' => 'Deleted']);
    }
}
