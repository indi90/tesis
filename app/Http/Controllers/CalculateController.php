<?php

namespace App\Http\Controllers;

use App\CalculateValue;
use App\History;
use App\Retail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculateController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retails = Retail::all();
        return view('calculate.input')->with('retails', $retails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
            'price'             => 'required|numeric',
            'rice'              => 'required|numeric',
            'sugar'             => 'required|numeric',
            'cooking_oil'       => 'required|numeric',
            'retails.*'         => 'required|distinct',
            'rice_demands.*'    => 'required',
            'sugar_demands.*'   => 'required',
            'oil_demands.*'     => 'required'
        ]);

        $sum_rice = 0;
        $sum_sugar = 0;
        $sum_oil = 0;
        for($i = 0; $i < count($request->retails); $i++){
            $sum_rice = $sum_rice + $request->rice_demands[$i];
            $sum_sugar = $sum_sugar + $request->sugar_demands[$i];
            $sum_oil = $sum_oil + $request->oil_demands[$i];
        }

        if ($sum_rice <= $request->rice and $sum_rice <= $request->rice and $sum_oil <= $request->cooking_oil){
            $retails = Retail::whereIn('id', $request->retails)->get();

//            dd($this->transportation_cost($request)['total_distance']);

            $history = Auth::user()->histories()->create([
                'development_cost'      => $this->development_cost($request),
                'transportation_cost'   => $this->transportation_cost($request)['total'],
                'track'                 => implode(',', $this->transportation_cost($request)['track']),
                'total_distance'        => $this->transportation_cost($request)['total_distance'],
                'saving_cost'           => $this->saving_cost($request),
                'longitude'             => $request->longitude,
                'latitude'              => $request->latitude
            ]);

            $history->retails()->sync($retails);

            return view('calculate.result', [
                'retails'               => $retails,
                'development_cost'      => $this->development_cost($request),
                'transportation_cost'   => $this->transportation_cost($request)['total'],
                'saving_cost'           => $this->saving_cost($request),
                'track'                 => implode('->', $this->transportation_cost($request)['track']),
                'total_distance'        => $this->transportation_cost($request)['total_distance'],
                'long_DC'               => $request->longitude,
                'lat_DC'                => $request->latitude,
                'user_id'               => Auth::user()->id
            ]);
        }
        flash()->error('Capacity overload !!');
        return redirect()->back()->withInput();

    }

    public function development_cost($request)
    {
        $A = $request->price * (($request->rice + $request->sugar + ($request->cooking_oil * 0.9))/500);
        $LD = $A * ((0.065*pow((1+0.065),30)) / (pow((1+0.065),30)-1));

        return $LD;
    }

    public function transportation_cost($request)
    {
        $count = count($request->retails);
        $transportation = CalculateValue::where('alias', 'transport')->first()->value;

        $TTC = 0;
        $waypoints = array();
        for ($i = 0; $i < $count; $i++){
            $retail = Retail::find($request->retails[$i]);
            $waypoints[$i] = $retail->latitude.','.$retail->longitude;
            $vdk = ($request->rice_demands[$i]+$request->sugar_demands[$i]+($request->oil_demands[$i]*0.9));
            $TTC = $TTC + $vdk;
        }

        $allDistance = GetTSPDistance($request->latitude, $request->longitude, $waypoints)['dist'];

//        dd(GetTSPDistance($request->latitude, $request->longitude, $waypoints)['locations'][1]['lat']);
        $retail = array();
        foreach (GetTSPDistance($request->latitude, $request->longitude, $waypoints)['locations'] as $key => $explode){
            $location = explode(',', $explode);
            $lat = $location[0];
            $lng = $location[1];
            $retail[$key] = Retail::where('latitude', $lat)->where('longitude', $lng)->first()->label;
//            dd($retail);
        }

        $total = str_replace(',','.',$allDistance) * $TTC * $transportation * 52;
        return array('track' => $retail, 'total' => $total, 'total_distance' => $allDistance);
    }

    public function saving_cost($request)
    {
        $rice = CalculateValue::where('alias', 'rice')->first()->value;
        $oil = CalculateValue::where('alias', 'oil')->first()->value;
        $sugar = CalculateValue::where('alias', 'sugar')->first()->value;

        $TVC = ($rice*$request->rice) + ($sugar*$request->sugar) + ($oil*($request->cooking_oil*0.9));
        return $TVC;
    }
}
