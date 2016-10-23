<?php

namespace App\Http\Controllers;

use App\Retail;
use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;

class RetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retails = Retail::orderBy('created_at', 'desc')->paginate(10);
        return view('retails.index')->with('retails', $retails);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('retails.create');
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
//    dd($request->upload_file);
    if ($request->upload_file){
        $this->validate($request, [
            'file'         => 'required'
        ]);

        Excel::load($request->file, function($reader)  {

            // Getting all results
//                $results = $reader->get();


            // ->all() is a wrapper for ->get() and will work the same
            $results = $reader->get();
            foreach ($results as $result){
                Retail::create(array(
                    'label'         => $result->no,
                    'latitude'      => $result->latitude,
                    'longitude'     => $result->longitude,
//                    'sub_district'  => $result->kecamatan,
//                    'district'      => $result->kabupaten,
                ));
            }

        });

    } else {
        $this->validate($request, [
            'label'         => 'required|unique:retails',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
//            'sub_district'  => 'required',
//            'district'      => 'required',
        ]);

        Retail::create($request->all());
    }

    flash()->success('Success add new retail.');
    return redirect()->route('retails.index');

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retail = Retail::find($id);
        return view('retails.edit')->with('retail', $retail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'label'         => 'required|unique:retails,label,'.$id.',id',
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
//            'sub_district'  => 'required',
//            'district'      => 'required',
        ]);

        $retail = Retail::find($id);
        $retail->fill($request->all());
        $retail->save();

        flash()->success('Success update retail.');
        return redirect()->route('retails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retail = Retail::find($id);
        $retail->delete();

        flash()->success('Success delete retail.');
        return redirect()->route('retails.index');
    }

    public function multiple_delete(Request $request)
    {
        if ($request->ajax()){
            Retail::whereIn('id', $request->retailID)->delete();
            flash()->success('Success delete retail.');
        } else {
            return 404;
        }
    }
}
