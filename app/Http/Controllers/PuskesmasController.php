<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $puskesmas = Puskesmas::find(1);
            $posyandus = Posyandu::with('folders')->get();
            foreach($posyandus as $posyandu) {
                $folderTerbaru = $posyandu['folders']->sortByDesc('created_at')->first();
                $folderTerbaru->setVisible(['nama', 'tanggal']);
                $posyandu['folder_terbaru'] = $folderTerbaru;
                $posyandu->setVisible(['id', 'nama', 'alamat_padukuhan', 'folder_terbaru']);
            }
            $puskesmas['posyandus'] = $posyandus;
            $puskesmas->setVisible(['nama', 'alamat', 'posyandus']);
            return responseAPI(200, 'Success', $puskesmas);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function edit(Puskesmas $puskesmas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Puskesmas $puskesmas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puskesmas  $puskesmas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puskesmas $puskesmas)
    {
        //
    }
}
