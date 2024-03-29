<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataCollection;
use App\Models\Folder;
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
                'posyandu_id' => $request->posyandu_id,
                'nama' => $request->nama,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nik' => $request->nik,
                'kk' => $request->kk,
                'bb_lahir' => $request->bb_lahir,
                'tb_lahir' => $request->tb_lahir,
                'anak_ke' => $request->anak_ke,
                'kia' => $request->kia,
                'imd' => $request->imd,
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
            return responseAPI(500, 'Failed', $e->getMessage());
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
            $children = Children::find($id);
            $datas = DataCollection::where('children_id', $children->id)->get();
            if($datas->count() == 0) {
                $children['data'] = null;
                $children['kategori'] = null;
            } else {
                $children['data'] = $datas;
                $children['data_latest'] = $children['data']->sortByDesc('created_at')->first();
                $children['kategori'] = getKategori($children['jenis_kelamin'], $children['data_latest']['bb'], $children['tgl_lahir']);
            }
            
            $children['umur'] = getUmur($children->tgl_lahir);
            $children->makeHidden(['data', 'data_latest']);
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
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
                'anak_ke' => $request->anak_ke,
                'kia' => $request->kia,
                'imd' => $request->imd,
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
            return responseAPI(500, 'Failed', $e->getMessage());
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

    public function based_posyandu($posyandu_id) {
        try {
            $folders = Folder::where('posyandu_id', $posyandu_id)->get(); // untuk mendapatkan folder dengan posyandu_id yang sesuai
            $dataCollectionsArray = array(); // untuk menampung data collections yang memiliki folder_id sesuai
            $foldersID = array();
            foreach($folders as $folder) {
                $dataCollections = DataCollection::where('folder_id', $folder->id)->get();
                foreach($dataCollections as $dataCollection) {
                    array_push($dataCollectionsArray, $dataCollection);
                }
                array_push($foldersID, $folder->id);
            }
            $childrenID = array(); // untuk menampung child id, fungsinya untuk masuk ke array unique
            foreach($dataCollectionsArray as $dataCollection) {
                array_push($childrenID, $dataCollection->children_id);
            }
            $childrenIDUnique = array_unique($childrenID); // fungsinya untuk simplier array children id yang banyak duplicate data
            $children = array(); // untuk nanti menjadi data dari response
            foreach($childrenIDUnique as $childID) {
                $child = Children::find($childID);
                $dataCollectionLatest = DataCollection::where('children_id', $child->id)->whereIn('folder_id', $foldersID)->latest()->first();
                $childDataNeeded = [
                    'children_id' => $child->id, 
                    'nama' => $child->nama,
                    'data_collection_latest' => $dataCollectionLatest
                ];
                array_push($children, $childDataNeeded);
            }
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    public function list_children($posyandu_id) { // only posyandu user could access this
        try {
            $children = Children::with('data.folder')->where('posyandu_id', $posyandu_id)->get();
            $children = filterChildrenBelow5Years($children);
            foreach($children as $child) {
                if(count($child['data']) == 0) {
                    $child['folder_terbaru'] = null;
                    $child->setVisible(['id', 'nama', 'folder_terbaru']);
                } else {
                    $folderTerbaru = $child['data']->sortByDesc('created_at')->first()->folder;
                    $folderTerbaru->setVisible(['id', 'nama', 'tanggal']);
                    $child['folder_terbaru'] = $folderTerbaru;
                    $child->setVisible(['id', 'nama', 'folder_terbaru']);
                }
            }
            return responseAPI(200, 'Success', $children);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }
    
    public function age($children_id) {
        try {
            $children = Children::find($children_id);
            $umur = getUmur($children->tgl_lahir);
            $data = [
                'umur' => $umur
            ];
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    public function export_data($folder_id) {
        try {
            $dataCollections = DataCollection::with('children')->where('folder_id', $folder_id)->get();
            $no = 1;
            foreach($dataCollections as $data) {
                $child = $data['children'];
                $data['no'] = $no++;
                $data['tanggal_lahir'] = $child['tgl_lahir'];
                $data['jk'] = strcmp($child['jenis_kelamin'], 'laki-laki') ? 'P' : 'L';
                $data['nomor_kk'] = $child['kk'];
                $data['nik'] = $child['nik'];
                $data['nama_anak'] = $child['nama'];
                $data['berat_lahir'] = $child['bb_lahir'];
                $data['tinggi_lahir'] = $child['tb_lahir'];
                $data['anak_ke'] = $child['anak_ke'];
                $data['kia'] = $child['kia'];
                $data['imd'] = $child['imd'];
                $data['nama_ortu'] = $child['ibu_nama'];
                $data['nik_ortu'] = $child['ibu_nik'];
                $data['hp_ortu'] = $child['ibu_hp'];
                $data['alamat'] = $child['alamat_padukuhan'];
                $data['rt'] = $child['alamat_rt'];
                $data['rw'] = $child['alamat_rw'];
                $data->setVisible(['no', 'tanggal_lahir', 'jk', 'nomor_kk', 'nik', 'nama_anak', 'berat_lahir', 'tinggi_lahir', 'anak_ke', 'kia', 'imd', 'nama_ortu', 'nik_ortu', 'hp_ortu', 'alamat', 'rt', 'rw', 'bb', 'tb', 'lika', 'lila', 'asi_eks', 'vit_a', 'pmba']);
            }
            return responseAPI(200, 'Success', $dataCollections);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

}
