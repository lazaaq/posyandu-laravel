<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Kelurahan;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class KelurahanController extends Controller
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
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $kelurahan = Kelurahan::find(1);
            $posyandus = Posyandu::with('folders')->get();
            $posyanduscount = $posyandus->count();
            $childrencount = Children::all()->count();
            foreach($posyandus as $posyandu) {
                $folder = $posyandu['folders']->sortByDesc('created_at')->take(1);
                $posyandu['folder_terbaru'] = $folder->setVisible(['nama', 'tanggal'])->toArray();
                $posyandu->makeHidden('folders')->toArray();
            }
            $data = [
                'kelurahan' => $kelurahan->setVisible(['nama', 'alamat'])->toArray(),
                'jumlah_posyandu' => $posyanduscount,
                'jumlah_anak' => $childrencount,
                'ringkasan' => null,
                'posyandus' => $posyandus->setVisible(['id', 'nama', 'alamat_padukuhan', 'folder_terbaru']),
            ];
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelurahan $kelurahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelurahan $kelurahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelurahan $kelurahan)
    {
        //
    }
}
