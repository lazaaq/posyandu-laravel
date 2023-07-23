<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class  PosyanduController extends Controller
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
        try {
            $posyandus = Posyandu::all();
            return responseAPI(200, 'Success', $posyandus);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
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
            $newUser = User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => 'posyandu'
            ]);
            $newPosyandu = Posyandu::create([
                'user_id' => $newUser->id,
                'nama' => $request->nama,
                'alamat_padukuhan' => $request->alamat_padukuhan
            ]);
            $data = $newPosyandu->load('user');
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posyandu  $posyandu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $posyandu = Posyandu::with('user', 'folders')->find($id);
            return responseAPI(200, 'Success', $posyandu);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
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
        try {
            $posyandu = Posyandu::find($id);
            if(!$posyandu) {
                return responseAPI(500, 'Failed', null);
            }
            $posyandu->delete();
            return responseAPI(200, 'Success', $posyandu);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    public function reset_password(Request $request) {
        try {
            $posyandu_id = $request->posyandu_id;
            $passwordBaru = $request->password_baru;
            $passwordConfirmation = $request->password_confirmation;
            if($passwordBaru == $passwordConfirmation) {
                $posyandu = Posyandu::find($posyandu_id);
                $user = User::find($posyandu->user_id);
                $user->update([
                    'password' => bcrypt($passwordBaru),
                ]);
                $user->load('posyandu');
                return responseAPI(200, 'Success', $user);
            } else {
                return responseAPI(400, 'Failed, password is not match', $request);
            }
        } catch(\Exception $e) {

        }
    }
}
