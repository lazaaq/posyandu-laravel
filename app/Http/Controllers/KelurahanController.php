<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataCollection;
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
            $children = Children::all();
            $children = filterChildrenBelow5Years($children);
            $childrencount = $children->count();
            foreach($posyandus as $posyandu) {
                if($posyandu['folders']->count() == 0) {
                    $posyandu['folder_terbaru'] = null;
                    continue;
                }
                $folder = $posyandu['folders']->sortByDesc('created_at')->take(1);
                $posyandu['folder_terbaru'] = $folder->setVisible(['nama', 'tanggal'])->toArray();
                $posyandu->makeHidden('folders')->toArray();
            }
            $ringkasanKategori = [
                "jumlah_stunting" => 0,
                "jumlah_gizi_buruk" => 0,
                "jumlah_kurang_gizi" => 0,
                "jumlah_obesitas" => 0,
                "jumlah_normal" => 0,
            ];
            foreach($children as $child) {
                $dataLatest = DataCollection::where('children_id', $child['id'])->get()->sortByDesc('created_at')->first();
                if($dataLatest == null) continue;
                $status = getKategori($child['jenis_kelamin'], $dataLatest['bb'], $child['tgl_lahir']);
                if($status == 'stunting') { $ringkasanKategori['jumlah_stunting'] += 1; }
                else if($status == 'gizi buruk') { $ringkasanKategori['jumlah_gizi_buruk'] += 1; }
                else if($status == 'kurang gizi') { $ringkasanKategori['jumlah_kurang_gizi'] += 1; }
                else if($status == 'obesitas') { $ringkasanKategori['jumlah_obesitas'] += 1; }
                else if($status == 'normal') { $ringkasanKategori['jumlah_normal'] += 1; }
            }
            $data = [
                'kelurahan' => $kelurahan->setVisible(['nama', 'alamat'])->toArray(),
                'jumlah_posyandu' => $posyanduscount,
                'jumlah_anak' => $childrencount,
                'ringkasan' => $ringkasanKategori,
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
