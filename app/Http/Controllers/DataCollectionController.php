<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataCollection;
use App\Models\Folder;
use Illuminate\Http\Request;

class DataCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function based_folder($folder_id) {
        try {
            $dataCollection = DataCollection::where('folder_id', $folder_id)->get();
            return responseAPI(200, 'Success', $dataCollection);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }
    public function based_posyandu($posyandu_id) {
        try {
            $folders = Folder::where('posyandu_id', $posyandu_id)->get();
            $folders_id = array();
            foreach($folders as $folder) {
                array_push($folders_id, $folder->id);
            }
            $dataCollection = DataCollection::whereIn('folder_id', $folders_id)->get();
            return responseAPI(200, 'Success', $dataCollection);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }
    public function based_children($children_id) {
        try {
            $dataCollection = DataCollection::where('children_id', $children_id)->get();
            return responseAPI(200, 'Success', $dataCollection);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
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
                'lile' => $request->lile,
            ]);
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataCollection  $dataCollection
     * @return \Illuminate\Http\Response
     */
    public function show(DataCollection $dataCollection)
    {
        //
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
    public function update(Request $request, DataCollection $dataCollection)
    {
        //
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
            $data->delete();
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    public function history($children_id) {
        try {
            $children = Children::find($children_id);
            $dataCollection = DataCollection::with('folder')->where('children_id', $children_id)->get();
            $data = [
                'children' => $children,
                'data_collection' => $dataCollection
            ];
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }
}
