<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Posyandu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FolderController extends Controller
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
            $folders = Folder::all();
            return responseAPI(200, 'Success', $folders);
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
            // check date (if folder in that month is exist, abort)
            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
            $latestData = Folder::latest()->first();
            $latestDataDate = Carbon::parse($latestData->created_at);
            $latestDataMonth = $latestDataDate->month;
            $latestDataYear = $latestDataDate->year;
            if($year == $latestDataYear && $month == $latestDataMonth) {
                return responseAPI(400, 'Failed, the folder in that month is already exist', null);
            } 
            // create folder
            $user = getUser();
            $folder = Folder::create([
                'posyandu_id' => $user->posyandu->id,
                'nama' => $request->nama,
                'tanggal' => $request->tanggal
            ]);
            $folder->load('posyandu');
            return responseAPI(200, 'Success', $folder);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $folder = Folder::with('posyandu')->find($id);
            return responseAPI(200, 'Success', $folder);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        //
    }

    public function based_posyandu($posyandu_id) {
        try {
            $posyandu = Posyandu::find($posyandu_id);
            $folders = Folder::with('dataCollections')->where('posyandu_id', $posyandu_id)->get();
            $data = [
                'posyandu' => $posyandu,
                'folders' => $folders
            ];
            return responseAPI(200, 'Success', $data);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e);
        }
    }
    
}
