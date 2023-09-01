<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataCollection;
use App\Models\Folder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class DataCollectionController extends Controller
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
            $data = DataCollection::create([
                'folder_id' => $request->folder_id,
                'children_id' => $request->children_id,
                'bb' => $request->bb,
                'tb' => $request->tb,
                'lika' => $request->lika,
                'lila' => $request->lila,
                'asi_eks' => $request->asi_eks,
                'pmba' => $request->pmba,
                'vit_a' => $request->vit_a,
            ]);
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataCollection  $dataCollection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dataCollection = DataCollection::with('children', 'folder')->find($id);
            $dataCollection->makeHidden(['created_at', 'updated_at']);
            $dataCollection['children']['kategori'] = getKategori($dataCollection['children']['jenis_kelamin'], $dataCollection['bb'], $dataCollection['children']['tgl_lahir']);
            $dataCollection['children']->setVisible(['nama', 'kategori']);
            $dataCollection['folder']->setVisible(['nama', 'tanggal']);
            return responseAPI(200, 'Success', $dataCollection);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataCollection  $dataCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(DataCollection $dataCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataCollection  $dataCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = DataCollection::find($id);
            if($data) {
                $data->update([
                    'bb' => $request->bb,
                    'tb' => $request->tb,
                    'lika' => $request->lika,
                    'lila' => $request->lila,
                    'asi_eks' => $request->asi_eks,
                    'pmba' => $request->pmba,
                    'vit_a' => $request->vit_a,
                ]);
                return responseAPI(200, 'Success', $data);
            } else {
                return responseAPI(400, "Failed, data isn't exist", $data);
            }
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataCollection  $dataCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy($data_id)
    {
        try {
            $data = DataCollection::find($data_id);
            if($data) {
                $data->delete();
                return responseAPI(200, 'Success', $data);
            } else {
                return responseAPI(400, "Failed, data isn't exist", $data);
            }
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }

    public function history($children_id) {
        try {
            $child= Children::with('posyandu')->find($children_id);
            if(!$child) {
                return responseAPI(400, "Failed, child isn't exist", null);
            }
            $dataCollection = DataCollection::with('folder')->where('children_id', $children_id)->orderBy('created_at', 'desc')->take(3)->get();
            if($dataCollection->count() == 0) {
                $child['kategori'] = null;
            } else {
                $child['kategori'] = getKategori($child['jenis_kelamin'], $dataCollection[0]['bb'], $child['tgl_lahir']);
            }
            
            // merapihkan response
            $child['posyandu']->setVisible(['nama']);
            $child->setVisible(['nama', 'kategori', 'posyandu']);
            foreach($dataCollection as $data) {
                $data['folder']->setVisible(['id', 'nama', 'tanggal']);
            }
            $dataCollection->makeHidden(['created_at', 'updated_at']);
            $data = [
                'children' => $child,
                'data_collection' => $dataCollection
            ];
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }
}
