<?php

namespace App\Http\Controllers\Workshop\MasterData;

use App\Http\Controllers\Controller;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\DepartemenModel;
use App\Repository\Workshop\SettingRepository;
use App\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting_items = \App\Repository\Workshop\SettingRepository::getAll();
        $users = User::with('karyawan')->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->karyawan->nm_lengkap];
        });
        $positions = JabatanModel::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->nm_jabatan];
        });
        $karyawans = KaryawanModel::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->nm_lengkap];
        });
        $department = DepartemenModel::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->nm_dept];
        });

        return view('Workshop.master-data.settings.index', [
            'setting_items' => $setting_items,
            'data' => [
                'users' => $users,
                'positions' => $positions,
                'karyawans' => $karyawans,
                'departments' => $department
            ]
        ]);
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
        if (\App\Repository\Workshop\SettingRepository::save($request->all())) {
            return redirect()->route('workshop.master-data.settings.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
