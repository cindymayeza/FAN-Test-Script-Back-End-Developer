<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EpresenceResource as ResourcesEpresenceResource;
use App\Models\Epresence;
use Illuminate\Http\Request;

use Illuminate\Support\Fascades\Validator;
use Illuminate\Http\Resource\EpresenceResource;


class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $epresence = Epresence::all();
        return response(['epresence' => EpresenceResource::collection($epresence), 'message'=> 'Data berhasil ditampilkan'], 200);
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

        $validator = Validator::make($data,[
            'id_users' => 'required',
            'type' => 'required',
            'is_approve' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Harus diisi']);
        }

        $epresence = Epresence::create($data);
        return response(['epresence' => new EpresenceResource($epresence), 'message'=>'Data berhasil ditambahkan'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Epresence  $epresence
     * @return \Illuminate\Http\Response
     */
    public function show(Epresence $epresence)
    {
        return response(['epresence' => new EpresenceResource($epresence), 'message'=>'Data berhasil diambil'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Epresence  $epresence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Epresence $epresence)
    {
        $epresence->update($request->all());
        return response(['epresence' => new EpresenceResource($epresence), 'message'=>'Data berhasil diubah'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Epresence  $epresence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Epresence $epresence)
    {
        $epresence->delete();

        return response(['message'=>'Data berhasil dihapus']);
    }
}
