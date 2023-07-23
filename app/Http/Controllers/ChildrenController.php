<?php

namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $children = Children::create([
                'nama' => $request->nama,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nik' => $request->nik,
                'kk' => $request->kk,
                'bb_lahir' => $request->bb_lahir,
                'tb_lahir' => $request->tb_lahir,
                'ibu_nama' => $request->ibu_nama,
                'ibu_nik' => $request->ibu_nik,
                'ibu_hp' => $request->ibu_hp,
                'alamat_padukuhan' => $request->alamat_padukuhan,
                'alamat_rt' => $request->alamat_rt,
                'alamat_rw' => $request->alamat_rw,
                'active' => $request->active,
            ]);
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $children = Children::with('data')->find($id);
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function edit(Children $children)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $children = Children::find($id);
            $children->update([
                'nama' => $request->nama,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nik' => $request->nik,
                'kk' => $request->kk,
                'bb_lahir' => $request->bb_lahir,
                'tb_lahir' => $request->tb_lahir,
                'ibu_nama' => $request->ibu_nama,
                'ibu_nik' => $request->ibu_nik,
                'ibu_hp' => $request->ibu_hp,
                'alamat_padukuhan' => $request->alamat_padukuhan,
                'alamat_rt' => $request->alamat_rt,
                'alamat_rw' => $request->alamat_rw,
                'active' => $request->active,
            ]);
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Children  $children
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $children = Children::find($id);
            if($children) {
                $children->delete();
                return responseAPI(200, 'Success', $children);
            } else {
                return responseAPI(400, "Failed, data isn't exist", $children);
            }
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', null);
        }
    }
}
