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
            // check date (if folder in that month is exist, abort)
            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
            $latestData = Folder::latest()->first();
            if($latestData != null) {
                $latestDataDate = Carbon::parse($latestData->tanggal);
                $latestDataMonth = $latestDataDate->month;
                $latestDataYear = $latestDataDate->year;
                if(($year < $latestDataYear) || ($year == $latestDataYear && $month <= $latestDataMonth)) {
                    $data = [$year, $latestDataYear, $month, $latestDataMonth];
                    return responseAPI(400, 'Failed, the folder in that month is already exist or you entered month that has passed', $data);
                } 
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
            return responseAPI(500, 'Failed', $e->getMessage());
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
            $folder = Folder::with('data.children')->find($id);
            $folder->setVisible(['nama', 'tanggal', 'data']);
            foreach($folder['data'] as $data) {
                $data['nama_anak'] = $data['children']['nama'];
                $data->setVisible(['id', 'nama', 'bb', 'tb', 'lika', 'nama_anak']);
            }
            return responseAPI(200, 'Success', $folder);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
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

    public function all_based_posyandu($posyandu_id) {
        try {
            $folders = Folder::where('posyandu_id', $posyandu_id)->get();
            foreach($folders as $folder) {
                $folder->setVisible(['id', 'nama', 'tanggal']);
            }
            return responseAPI(200, 'Success', $folders);
        } catch(\Exception $e) {
            return responseAPI(500, 'Failed', $e->getMessage());
        }
    }
    
}
