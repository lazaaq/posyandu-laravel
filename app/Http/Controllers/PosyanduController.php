<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Http\Request;

class  PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posyandus = Posyandu::all();
        return $posyandus;
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
        $newUser = User::create([
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'posyandu'
        ]);
        $newPosyandu = Posyandu::create([
            'user_id' => $newUser->id,
            'nama' => $request->nama,
            'alamat_padukuhan' => $request->alamat_padukuhan
        ]);
        return $newPosyandu->load('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posyandu = Posyandu::find($id);
        return $posyandu->load('user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function edit(Posyandu $posyandu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posyandu $posyandu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posyandu = Posyandu::find($id);
        $status = $posyandu->delete();
        if($status) {
            return [
                'status' => 'successfully deleted',
                'data' => $posyandu
            ];
        }
    }
}
