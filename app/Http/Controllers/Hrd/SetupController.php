<?php

namespace App\Http\Controllers\Hrd;

use App\Exports\TemplateGapokExport;
use App\Http\Controllers\Controller;
use App\Imports\GapokEImport;
use App\Models\auth\PermissionModel;
use Illuminate\Http\Request;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\LevelJabatanModel;
use App\Models\HRD\SetupPersetujuanModel;
use App\Models\HRD\JabatanModel;
use App\Models\HRD\KPIMasterModel;
use App\Models\HRD\KPIModel;
use App\Models\HRD\KPIPeriodikDetailModel;
use App\Models\HRD\KPISatuanModel;
use App\Models\HRD\KPITipeModel;
use App\Models\HRD\NormaPsikotesModel;
use App\Models\HRD\PotonganGajiKaryawanModel;
use App\Models\HRD\PotonganGajiModel;
use App\Models\HRD\RefApprovalDetailModel;
use App\Models\HRD\RefApprovalModel;
use App\Models\HRD\SetupHariLiburModel;
use App\Models\HRD\SetupBPJSModel;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class SetupController extends Controller
{
    //modul persetujuan
    public function persetujuan()
    {
        // $res_set_1 = SetupPersetujuanModel::where('id', 1)->first();
        // $res_level = LevelJabatanModel::where('status', 1)->orderby('level')->get();
        // $res_jabatan = JabatanModel::where('status', 1)->where('id_level', 4)->orderby('id')->get();
        // return view('HRD.setup.persetujuan.index', ['list_level' => $res_level, 'dt_set_1' => $res_set_1, 'list_jabatan' => $res_jabatan]);
        $res_all_setup = SetupPersetujuanModel::all();
        $res_level = LevelJabatanModel::where('status', 1)->orderby('level')->get();
        $res_jabatan = JabatanModel::where('status', 1)->where('id_level', 4)->orderby('id')->get();
        return view('HRD.setup.persetujuan.index', ['list_level' => $res_level, 'res_all_setup' => $res_all_setup, 'list_jabatan' => $res_jabatan]);

    }
    public function persetujuan_form($id)
    {
        $main = SetupPersetujuanModel::find($id);
        $res_level = LevelJabatanModel::where('status', 1)->orderby('level')->get();
        $res_jabatan = JabatanModel::where('status', 1)->where('id_level', 4)->orderby('id')->get();
        return view('HRD.setup.persetujuan.form_add', ['list_level' => $res_level, 'main' => $main, 'list_jabatan' => $res_jabatan]);

    }
    public function simpan_pengaturan_persetujuan(Request $request)
    {
        $id_modul = $request->id_modul;
        if (!empty($request->pil_lvl_pengajuan_cuti)) {
            $pil_lvl_pengajuan = implode(",", $request->pil_lvl_pengajuan_cuti);
        } else {
            $pil_lvl_pengajuan = "";
        }
        $update_1 = SetupPersetujuanModel::find($id_modul);
        $update_1->lvl_pengajuan = $pil_lvl_pengajuan;
        $update_1->lvl_persetujuan = $request->pil_lvl_persetujuan_cuti;
        $update_1->id_dept_manager_hrd = $request->pil_lvl_persetujuan_cuti_hrd;
        $update_1->save();
        return redirect('hrd/setup/persetujuan')->with('konfirm', 'Pengaturan Level Pengajuran dan Persetujuan  berhasil disimpan');
    }
    //manajemen pengguna
    //menu/permission
    public function tambah_menu()
    {
        return view("HRD.auth.menu.add");
    }
    public function simpan_menu(Request $request)
    {
        $vcat = $request->pil_kategori;
        $vmenu = $request->inp_nama_menu;
        $nama_menu = $vcat . "-" . $vmenu;
        Permission::create(['name' => $nama_menu]);
        return redirect('hrd/setup/manajemengroup')->with('konfirm', 'Menu baru berhasil ditambahkan');
    }
    public function manajemen_group_utama()
    {
        $data['roles'] = Role::where("id", ">", 1)->get();
        $data['permission_hrd'] = Permission::where("id", ">", 1)->get();
        return view("HRD.auth.group.index_baru", $data);
    }

    public function manajemen_group()
    {
        $data['roles'] = Role::where("id", ">", 1)->get();
        $data['permission_hrd'] = Permission::where("id", ">", 1)->get();
        return view("HRD.auth.group.index", $data);
    }
    public function manajemen_group_add()
    {
        return view("HRD.auth.group.add");
    }

    public function simpan_group(Request $request)
    {
        // dd($request->menu_warehouse);
        $role = Role::findOrCreate($request->inp_nama_group);
        $hrd = $request->has('menu_hrd') ? $request->menu_hrd : [];
        $warehouse = $request->has('menu_warehouse') ? $request->menu_warehouse : [];
        $workshop = $request->has('menu_workshop') ? $request->menu_workshop : [];

        foreach ($hrd as $mn) {
            $result_permission = Permission::where('name', $mn)->get();

            //dd($id_permission);

            if (count($result_permission) == 0) {
                $permission = Permission::create(['name' => $mn]);
                $role->givePermissionTo($permission);
            } else {
                foreach ($result_permission as $key => $val) {
                    $id_permission = $val['id'];
                }
                $role->givePermissionTo($id_permission);
            }
        }

        foreach ($warehouse as $menu) {
            $permission = Permission::firstOrCreate(['name' => $menu]);
            $role->givePermissionTo($permission);
        }

        foreach ($workshop as $menu) {
            $permission = Permission::firstOrCreate(['name' => $menu]);
            $role->givePermissionTo($permission);
        }

        return redirect('hrd/setup/manajemengroup')->with('konfirm', 'Group Pengguna baru berhasi disimpan');
    }
    public function edit_group($id)
    {
        $roles = Role::query()->with('permissions')->where('id', $id)->first();

        $data['roles'] = $roles;
        $data['permission_roles'] = $roles->permissions;
        $data['permission_hrd'] = Permission::where("id", ">", 1)->get();
        return view('HRD.auth.group.edit_baru', $data);
    }
    public function update_group(Request $request, $id)
    {
        $update_roles = Role::find($id);
        $update_roles->name = $request->inp_nama_group;
        $update_roles->save();
        //menghapus data sebelumnya
        $permission_roles = $update_roles->permissions;
        $hrd = $request->has('menu_hrd') ? $request->menu_hrd : [];
        $warehouse = $request->has('menu_warehouse') ? $request->menu_warehouse : [];
        $workshop = $request->has('menu_workshop') ? $request->menu_workshop : [];

        foreach ($permission_roles as $dt) {
            $id_permission = $dt->id;
            $update_roles->syncPermissions($dt->id);
        }
        //menyimpan permission baru
        foreach ($hrd as $mn) {
            $result_permission = Permission::where('name', $mn)->get();

            //dd($id_permission);

            if (count($result_permission) == 0) {
                $permission = Permission::create(['name' => $mn]);
                $update_roles->givePermissionTo($permission);
            } else {
                foreach ($result_permission as $key => $val) {
                    $id_permission = $val['id'];
                }
                $update_roles->givePermissionTo($id_permission);
            }
        }

        foreach ($warehouse as $menu) {
            $permission = Permission::firstOrCreate(['name' => $menu]);
            $update_roles->givePermissionTo($permission);
        }

        foreach ($workshop as $menu) {
            $permission = Permission::firstOrCreate(['name' => $menu]);
            $update_roles->givePermissionTo($permission);
        }

        //$update_roles->givePermissionTo($request->menu);
        return redirect('hrd/setup/manajemengroup')->with('konfirm', 'Perubahan Group Pengguna berhasi disimpan');
    }
    public function delete_group($id)
    {
        $roles = Role::find($id);
        $permission_roles = $roles->permissions;
        //dd($permission_roles);
        foreach ($permission_roles as $dt) {
            $roles->syncPermissions($dt->id);
        }
        $roles->delete();
        return redirect('hrd/setup/manajemengroup')->with('konfirm', 'Group Pengguna berhasi dihapus');
    }
    //manajemen pengguna
    public function manajemen_pengguna()
    {

        $data['roles'] = Role::where('id', '>', 1)->get();
        $data['karyawan_aktif'] = KaryawanModel::with('get_jabatan', 'get_departemen')->doesntHave('user')->whereNotNull('id_jabatan')->whereIn("id_status_karyawan", [1, 2, 3])->get();
        $data['daftar_user'] = User::with('karyawan', 'karyawan.get_departemen')->where('id', '<>', 1)->get();

        return view("HRD.auth.pengguna.index", $data);
    }
    public function add_roles_pengguna()
    {
        $data['roles'] = Role::where('id', '>', 1)->get();
        $data['karyawan_aktif'] = KaryawanModel::doesntHave('user')->whereNotNull('id_jabatan')->whereIn("id_status_karyawan", [1, 2, 3])->get();
        return view("HRD.auth.pengguna.add", $data);
    }
    public function simpan_roles_pengguna(Request $request)
    {

        try {
            $karyawan = KaryawanModel::findOrFail($request->pil_karyawan);
            $user = new User();
            $user->nik = $karyawan->nik;
            $user->email_verified_at = now();
            $user->password = Hash::make('123456'); //password default
            $user->save();
            $user->assignRole($request->roles);
            return redirect('hrd/setup/manajemenpengguna')->with('konfirm', 'Roles Pengguna berhasi disimpan');
        } catch (QueryException $e) {
            $data = [
                'success' => 'false',
                'message' => 'Proses penyimpanan data gagal. Error : ' . $e->errorInfo
            ];
            return redirect('hrd/setup/manajemenpengguna')->with('konfirm', $data);
        }
        /*
        $karyawan = KaryawanModel::findOrFail($request->pil_karyawan);
        $user = new User();
        $user->nik = $karyawan->nik;
        $user->name = $karyawan->nm_lengkap;
        $user->email = $karyawan->nmemail;
        $user->email_verified_at = now();
        $user->password = Hash::make('123456'); //password default
        $user->save();
        $user->assignRole($request->roles);

        return redirect('hrd/setup/manajemenpengguna')->with('konfirm', 'Roles Pengguna berhasi disimpan');
        */
    }
    public function edit_roles_pengguna($id)
    {

        //dd(User::with("karyawan")->where('id', $id)->get()->karyawan());
        $user = User::find($id);
        $roles_user = $user->roles;
        $data['roles_user'] = $roles_user;
        $data['user_profil'] = $user;
        $data['roles'] = Role::where('id', '>', 1)->get();
        return view("HRD.auth.pengguna.edit", $data);
    }

    public function update_roles_pengguna(Request $request, $id)
    {
        $user = User::find($id);
        //dd($id);
        $user->syncRoles($request->roles);
        return redirect('hrd/setup/manajemenpengguna')->with('konfirm', 'Perubahan Roles Pengguna berhasi disimpan');
    }
    public function delete_roels_pengguna($id)
    {
        $user = User::find($id);
        $roles_user = $user->roles;
        foreach ($roles_user as $lroles) {
            $user->removeRole($lroles->id);
        }
        $user->delete();
        return redirect('hrd/setup/manajemenpengguna')->with('konfirm', 'Roles Pengguna berhasi dihapus');
    }
    //profil user
    public function profil_user()
    {
        return view("HRD.auth.pengguna.profil");
    }

    public function profil_user_update(Request $request)
    {
        $update = User::find(auth()->user()->id);
        $update->password = Hash::make($request['npassnew']);
        $update->update();
        Auth::logout();
        return redirect('/hrd');
    }
    //setting hari libur
    public function hari_libur()
    {
        $data['list_hari_libur'] = SetupHariLiburModel::where('tahun', date('Y'))->orderby('tanggal', 'asc')->get();
        return view('HRD.setup.hari_libur.index', $data);
    }
    public function simpan_hari_libur(Request $request)
    {
        $simpan = SetupHariLiburModel::create([
            'tahun' => date("Y"),
            'tanggal' => $request->tgl_libur,
            'keterangan' => $request->keterangan
        ]);
        return redirect('hrd/setup/harilibur')->with('konfirm', 'Data berhasil disimpan');
    }
    public function edit_hari_libur($id)
    {
        $data['profil_hari_libur'] = SetupHariLiburModel::find($id);
        return view('HRD.setup.hari_libur.edit', $data);
    }
    public function update_hari_libur(Request $request, $id)
    {
        $update = SetupHariLiburModel::find($id);
        $update->tanggal = $request->tgl_libur;
        $update->keterangan = $request->keterangan;
        $update->save();
        return redirect('hrd/setup/harilibur')->with('konfirm', 'Perubaha Data berhasil disimpan');
    }
    public function hapus_hari_libur($id)
    {
        $del = SetupHariLiburModel::find($id);
        $del->delete();
        return redirect('hrd/setup/harilibur')->with('konfirm', 'Data berhasil dihapus');
    }
    //manajemen gapok
    public function manajemen_gapok()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.setup.manajemen_gaji.index', $data);
    }
    public function tampilkan_karyawan_gapok(Request $request)
    {
        $id_dept = $request->pil_departemen;
        if($id_dept==0){
            $data['all_karyawan_gapok'] = KaryawanModel::select([
                "hrd_karyawan.id",
                "hrd_karyawan.nik",
                "hrd_karyawan.nm_lengkap",
                "hrd_karyawan.gaji_pokok",
                "hrd_karyawan.gaji_bpjs",
                "hrd_karyawan.gaji_jamsostek",
                "hrd_karyawan.id_status_karyawan",
                "mst_hrd_jabatan.nm_jabatan",
                "mst_hrd_level_jabatan.level",
                "mst_hrd_departemen.nm_dept"
            ])
                ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
                ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
                ->leftJoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
                ->where('hrd_karyawan.nik', '<>', '999999999')
                ->whereNotIn('hrd_karyawan.id_status_karyawan', [4, 5, 6])
                ->orderBy('mst_hrd_level_jabatan.level')->get();
            // $data['all_karyawan_gapok'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])
            // ->orderBy('id_jabatan')
            // ->orderBy('nik')
            // ->orderBy('tgl_masuk')->get();
        } else {
            $data['all_karyawan_gapok'] = KaryawanModel::select([
                "hrd_karyawan.id",
                "hrd_karyawan.nik",
                "hrd_karyawan.nm_lengkap",
                "hrd_karyawan.gaji_pokok",
                "hrd_karyawan.gaji_bpjs",
                "hrd_karyawan.gaji_jamsostek",
                "hrd_karyawan.id_status_karyawan",
                "mst_hrd_jabatan.nm_jabatan",
                "mst_hrd_level_jabatan.level",
                "mst_hrd_departemen.nm_dept"
            ])
                ->leftJoin('mst_hrd_jabatan', 'hrd_karyawan.id_jabatan', '=', 'mst_hrd_jabatan.id')
                ->leftJoin('mst_hrd_departemen', 'hrd_karyawan.id_departemen', '=', 'mst_hrd_departemen.id')
                ->leftJoin('mst_hrd_level_jabatan', 'mst_hrd_jabatan.id_level', '=', 'mst_hrd_level_jabatan.id')
                ->where('hrd_karyawan.nik', '<>', '999999999')
                ->whereNotIn('hrd_karyawan.id_status_karyawan', [4, 5, 6])
                ->where('hrd_karyawan.id_departemen', $id_dept)
                ->orderBy('mst_hrd_level_jabatan.level')->get();
            // $data['all_karyawan_gapok'] = KaryawanModel::whereIn('id_status_karyawan', [1, 2, 3])
            // ->where('id_departemen', $id_dept)
            // ->orderBy('id_jabatan')
            // ->orderBy('nik')
            // ->orderBy('tgl_masuk')->get();
        }

        return view('HRD.setup.manajemen_gaji.daftar_gapok', $data);
    }
    public function manajemen_gapok_simpan(Request $request)
    {
        $jml_baris = count($request->id_karyawan);

        foreach (array($request) as $key => $value) {
            for ($i = 0; $i < $jml_baris; $i++) {
                $update = KaryawanModel::find($value['id_karyawan'][$i]);
                $update->gaji_pokok = str_replace(",", "", $value['inp_gapok'][$i]);
                $update->gaji_bpjs = str_replace(",", "", $value['inp_gaji_bpjs'][$i]);
                $update->gaji_jamsostek = str_replace(",", "", $value['inp_gaji_jamsostek'][$i]);
                $update->save();
            }
        }
        return redirect('hrd/setup/manajemengapok')->with('konfirm', 'Pengaturan Gaji Pokok Karyawan berhasil disimpan');
    }
    //manajemen bpjs
    public function manajemen_bpjs()
    {
        $data['persen_bpjs'] = SetupBPJSModel::first();
        return view('HRD.setup.manajemen_bpjs_kt.index', $data);
    }
    public function manajemen_bpjs_simpan(Request $request)
    {
        if (empty($request->id_data)) {
            SetupBPJSModel::create([
                'jht_karyawan' => $request->inp_persen_jht_karyawan,
                'jht_perusahaan' => $request->inp_persen_jht_perusahaan,
                'jkk_karyawan' => $request->inp_persen_jkk_karyawan,
                'jkk_perusahaan' => $request->inp_persen_jkk_perusahaan,
                'jkm_karyawan' => $request->inp_persen_jkm_karyawan,
                'jkm_perusahaan' => $request->inp_persen_jkm_perusahaan,
                'jp_karyawan' => $request->inp_persen_jp_karyawan,
                'jp_perusahaan' => $request->inp_persen_jp_perusahaan,
                'bpjsks_karyawan' => $request->inp_persen_bpjsks_karyawan,
                'bpjsks_perusahaan' => $request->inp_persen_bpjsks_perusahaan,
            ]);
        } else {
            $update = SetupBPJSModel::find($request->id_data);
            $update->jht_karyawan = $request->inp_persen_jht_karyawan;
            $update->jht_perusahaan = $request->inp_persen_jht_perusahaan;
            $update->jkk_karyawan = $request->inp_persen_jkk_karyawan;
            $update->jkk_perusahaan = $request->inp_persen_jkk_perusahaan;
            $update->jkm_karyawan = $request->inp_persen_jkm_karyawan;
            $update->jkm_perusahaan = $request->inp_persen_jkm_perusahaan;
            $update->jp_karyawan = $request->inp_persen_jp_karyawan;
            $update->jp_perusahaan = $request->inp_persen_jp_perusahaan;
            $update->bpjsks_karyawan = $request->inp_persen_bpjsks_karyawan;
            $update->bpjsks_perusahaan = $request->inp_persen_bpjsks_perusahaan;
            $update->save();
        }
        return redirect('hrd/setup/manajemenbpjs')->with('konfirm', 'Pengaturan Persentase BPJS berhasil disimpan');
    }
    //import gapok
    public function manajemen_gapok_import()
    {
        return view('HRD.setup.manajemen_gaji.form_import');
    }
    public function manajemen_gapok_download_template()
    {
        return Excel::download(new TemplateGapokExport, 'templateGapokBpjsJamsostekKaryawan.xlsx');
    }
    public function manajemen_gapok_do_import(Request $request)
    {
        try {
            // dd(request()->file_imp);
            Excel::import(new GapokEImport, request()->file_imp);
            return back()->with('konfirm', 'Excel file import succesfully');
        } catch (\Exception $ex) {
            return back()->with('konfirm', $ex->getMessage());
        }
    }

    //manajemen potongan gaji
    public function manajemen_potongan_gaji()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.setup.manajemen_potongan_gaji.index', $data);
    }
    public function tampilkan_karyawan_potongan_gaji(Request $request)
    {
        $id_dept = $request->pil_departemen;
        $data['all_karyawan_potongan'] = KaryawanModel::with(['get_potongan_karyawan'])
            ->whereIn('id_status_karyawan', [1, 2, 3])->where('id_departemen', $id_dept)->get();
        return view('HRD.setup.manajemen_potongan_gaji.daftar_potongan', $data);
    }
    public function form_karyawan_potongan_gaji($id)
    {
        $profil_karyawan = KaryawanModel::find($id);
        $result = PotonganGajiKaryawanModel::with('get_item_potongan')->where('id_karyawan', $id)->get();
        $list_item_potongan = PotonganGajiModel::where('status', 1)->get();
        if ($result->count() == 0) {
            return view('HRD.setup.manajemen_potongan_gaji.inputan_baru', compact('list_item_potongan', 'profil_karyawan'));
        } else {
            return view('HRD.setup.manajemen_potongan_gaji.inputan_edit', compact('result', 'profil_karyawan'));
        }
    }
    public function manajemen_potongan_simpan(Request $request, $id_karyawan)
    {
        $jml_baris = count($request->id_potongan);

        foreach (array($request) as $key => $value) {
            for ($i = 0; $i < $jml_baris; $i++) {
                PotonganGajiKaryawanModel::create([
                    'id_karyawan' => $id_karyawan,
                    'id_potongan' => $value['id_potongan'][$i],
                    'jumlah' => str_replace(",", "",  $value['inp_nominal'][$i])
                ]);
            }
        }
        return redirect('hrd/setup/manajemenpot')->with('konfirm', 'Pengaturan Potongan Gaji Karyawan berhasil disimpan');
    }

    public function manajemen_potongan_update(Request $request, $id_karyawan)
    {
        $jml_baris = count($request->id_potongan);

        foreach (array($request) as $key => $value) {
            for ($i = 0; $i < $jml_baris; $i++) {
                $update = PotonganGajiKaryawanModel::find($value['id_potongan'][$i]);
                $update->jumlah = str_replace(",", "", $value['inp_nominal'][$i]);
                $update->update();
            }
        }
        return redirect('hrd/setup/manajemenpot')->with('konfirm', 'Pengaturan Potongan Gaji Karyawan berhasil disimpan');
    }

    //norma psikotest
    public function norma_psikotest()
    {
        $data = [
            'list_norma' => NormaPsikotesModel::orderBy('skor_maks', 'desc')->get()
        ];
        return view('HRD/setup/norma_psikotest/index', $data);
    }
    public function norma_psikotest_simpan(Request $request)
    {
        $data = [
            'skor_min' => $request->inp_skor_min,
            'skor_maks' => $request->inp_skor_maks,
            'hasil' => $request->inp_hasil,
        ];
        NormaPsikotesModel::create($data);
        return redirect('hrd/setup/norma_psikotest')->with('konfirm', 'Data berhasil disimpan');
    }
    public function norma_psikotest_edit($id)
    {
        $data = [
            'data' => NormaPsikotesModel::find($id)
        ];
        return view('HRD/setup/norma_psikotest/edit', $data);
    }
    public function norma_psikotest_update(Request $request, $id)
    {
        $data = [
            'skor_min' => $request->inp_skor_min,
            'skor_maks' => $request->inp_skor_maks,
            'hasil' => $request->inp_hasil,
        ];
        NormaPsikotesModel::find($id)->update($data);
        return redirect('hrd/setup/norma_psikotest')->with('konfirm', 'Perubahan data berhasil disimpan');
    }
    public function norma_psikotest_hapus($id)
    {
        NormaPsikotesModel::find($id)->delete();
        return redirect('hrd/setup/norma_psikotest')->with('konfirm', 'Data berhasil dihapus');
    }
    public function get_hasil(Request $request)
    {
        $nilai = $request->nilai;
        $hasil = NormaPsikotesModel::where('skor_min', '<=', $nilai)->where('skor_maks', ">=", $nilai)->first();
        $result =  $hasil ? $hasil['hasil'] : "";
        return response()->json([
            'result' => $result
        ]);
    }
    //matriks pkwt
    public function matriks_pkwt()
    {
        $data = [
            'list_jabatan' => JabatanModel::with([
                'mst_departemen',
                'mst_subdepartemen'
            ])->whereNotNull('id_divisi')->where('status', 1)->orderBy('id_level')->get()
        ];
        return view('HRD/setup/matriks_pkwt/index', $data);
    }

    public function getDataMatriksPkwt(Request $request)
    {
        $result = JabatanModel::with([
            'mst_departemen',
            'mst_subdepartemen'
        ])->find($request->id_jabatan);

        return response()->json([
            'id_jabatan' => $result->id,
            'jabatan' => $result->nm_jabatan,
            'departemen' => (empty($result->id_dept)) ? "" : $result->mst_departemen->nm_dept,
            'sub_dept' => (empty($result->id_subdept)) ? "" : $result->mst_subdepartemen->nm_subdept,
            'output' => $result->file_pkwt
        ]);
    }

    public function getListMatriks($output)
    {
        $matriks = array(
            array('Output' => 'pkwt_sre', 'Desc' => 'HRD - Recruitment, Development, & Evaluasi'),
            array('Output' => 'pkwt_adm_hi_dev', 'Desc' => 'HRD - Administrasi, Hubungan Industrial, & Development'),
            array('Output' => 'pkwt_kasir', 'Desc' => 'FINANCE - Kasir'),
            array('Output' => 'pkwt_staff_pajak', 'Desc' => 'FINANCE - Staf Perpajakan'),
            array('Output' => 'pkwt_staff_jurnal', 'Desc' => 'FINANCE - Staf Jurnal Umum'),
            array('Output' => 'pkwt_staff_bukubesar', 'Desc' => 'FINANCE - Staf Buku Besar'),
            array('Output' => 'pkwt_kabag_akuntansi', 'Desc' => 'FINANCE - Kabag Akunting'),
            array('Output' => 'pkwt_kabag_keuangan', 'Desc' => 'FINANCE - Kabag Keuangan'),
            array('Output' => 'pkwt_hse_safety_officer', 'Desc' => 'HSE - Safety Officer'),
            array('Output' => 'pkwt_project_analyst', 'Desc' => 'PROJECT - Analyst Project'),
            array('Output' => 'pkwt_project_adm', 'Desc' => 'PROJECT - Administrasi Project'),
            array('Output' => 'pkwt_project_site_spv', 'Desc' => 'PROJECT - Site Supervisor'),
            array('Output' => 'pkwt_project_operator_ab_driver_dt', 'Desc' => 'PROJECT - Operator Alat Berat / Driver Dumptruct'),
            array('Output' => 'pkwt_wrsp_kabag_plan_maint', 'Desc' => 'WORKSHOP - Kabag Plan Maintanance'),
            array('Output' => 'pkwt_wrsp_admin', 'Desc' => 'WORKSHOP - Administrasi Workshop'),
            array('Output' => 'pkwt_wrsp_painting_fabrication', 'Desc' => 'WORKSHOP - Painting Fabrication'),
            array('Output' => 'pkwt_wrsp_mekanik_ab', 'Desc' => 'WORKSHOP - Mekanik Alat Berat'),
            array('Output' => 'pkwt_wrsp_helper_mekanik_ab', 'Desc' => 'WORKSHOP - Helper Mekanik Alat Berat'),
            array('Output' => 'pkwt_wrsp_tire_handler', 'Desc' => 'WORKSHOP - Tire Handler'),
            array('Output' => 'pkwt_wrsp_tools_keeper', 'Desc' => 'WORKSHOP - Tools Keeper'),
            array('Output' => 'pkwt_wrsp_welding_fabrication', 'Desc' => 'WORKSHOP - Welding & Fabrication'),
            array('Output' => 'pkwt_wrhs_penerimaan', 'Desc' => 'WAREHOUSE - Penerimaan Barang - Kasir Kas Kecil'),
            array('Output' => 'pkwt_wrhs_pengelolaan_persediaan', 'Desc' => 'WAREHOUSE - Pengelolaan Persediaan'),
        );
        $html = "<option></option>";
        foreach($matriks as $list){
            if($list['Output'] === $output) {
                $html .="<option value=".$list['Output']." selected>".$list['Desc']."</option>";
            } else {
                $html .="<option value=".$list['Output'].">".$list['Desc']."</option>";
            }
        }
        echo $html;
    }

    public function store_matriks_pkwt(Request $request)
    {
        try {
            $id_jabatan = $request->id_jabatan;
            $update = JabatanModel::find($id_jabatan)->update([
                'file_pkwt' => $request->pil_output
            ]);
            return redirect('hrd/setup/matriks_pkwt')->with('konfirm', 'Data berhasil disimpan');
        } catch (Exception $e) {
            return redirect('hrd/setup/matriks_pkwt')->with('konfirm', $e->getMessage());
        }

    }

    //matriks persetujuan
    public function matriks_persetujuan()
    {
        $data = [
            "list_matriks" => RefApprovalModel::orderBy('id')->get()->map( function($row) {
                $arr = $row->toArray();
                $idGroup = $row['id'];
                $arr['list_departemen'] = DepartemenModel::with(['get_master_divisi'])->where('status', 1)->get()->map(function($row2) use($idGroup){
                    $arr2 = $row2->toArray();
                    $arr2['list_matriks'] = RefApprovalDetailModel::with(['getPejabat'])->where('approval_group', $idGroup)->where('approval_departemen', $row2['id'])->get();
                    return $arr2;
                });
                return $arr;
            }),
            // 'list_departemen' => DepartemenModel::where('status', 1)->get()
        ];
        // dd($data);
        return view('HRD.setup.matriks_persetujuan.index', $data);
    }
    public function matriks_persetujuan_setup($id)
    {
        $data = [
            "group" => RefApprovalModel::find($id),
            'list_departemen' => DepartemenModel::where('status', 1)->get(),
        ];
        return view('HRD.setup.matriks_persetujuan.baru', $data);
    }
    public function getDataMatriks($group, $departemen)
    {
        $next_level = RefApprovalDetailModel::where('approval_group', $group)->where('approval_departemen', $departemen)->orderBy('approval_level', 'desc')->first();
        $data = [
            'list_matriks' => RefApprovalDetailModel::with(['getPejabat'])->where('approval_group', $group)->where('approval_departemen', $departemen)->get(),
            'list_karyawan' => KaryawanModel::with(['get_jabatan'])->whereNotNull('id_jabatan')->whereIn("id_status_karyawan", [1, 2, 3])->get(),
            'current_level' => (empty($next_level->approval_level)) ? 1 : ($next_level->approval_level + 1)
        ];
        return view('HRD.setup.matriks_persetujuan.form_add', $data);
    }
    public function matriks_persetujuan_setup_store(Request $request)
    {
        $data = [
            "approval_group" => $request->id_group,
            "approval_level" => $request->level,
            "approval_by_employee" => $request->id_pejabat,
            "approval_departemen" => $request->id_departemen
        ];
        $exec = RefApprovalDetailModel::insert($data);
        if($exec) {
            return response()->json([
                'success' => true,
                'message' => "Data berhasil disimpan"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Data gagal disimpan"
            ]);
        }
    }
    public function matriks_persetujuan_setup_delete($id)
    {
        $queryDel = RefApprovalDetailModel::find($id)->delete();
        if($queryDel) {
            return response()->json([
                'success' => true,
                'message' => "Data berhasil dihapus"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Data gagal dihapus"
            ]);
        }
    }
    //pengaturan kpi departemem
    public function kpi_list()
    {
        $data['all_departemen'] = DepartemenModel::where('status', 1)->get()->map( function ($row){
                $arr = $row->toArray();
                $arr['list_kpi'] = KPIMasterModel::with([
                    'tipeKPI',
                    'satuanKPI'
                ])->where('id_departemen', $arr['id'])->get();
                return $arr;
            });
        return view('HRD.setup.kpi.index', $data);
    }

    public function kpi_departemen($departemen)
    {
        $data = [
            'id_dept' => $departemen,
            'nama_departemen' => DepartemenModel::find($departemen)->nm_dept,
            'kpi' => KPIModel::with(
                [
                    'Perspektif',
                    'SasaranStrategi',
                    'TipeKPI',
                    'SatuanKPI'
                ]
            )
                        ->where('id_departemen', $departemen)->get()
        ];
        return view('HRD.setup.kpi.resultFilter', $data);
    }

    public function kpi_departemen_baru($id)
    {
        $data = [
            'departemen' => DepartemenModel::find($id),
            'allTipe' => KPITipeModel::where('active', 1)->get(),
            'allSatuan' => KPISatuanModel::where('active', 1)->get(),
        ];
        return view('HRD.setup.kpi.add', $data);
    }
    public function kpi_departemen_simpan(Request $request)
    {
        try
        {
             $data = [
                'id_departemen' => $request->id_dept,
                'id_tipe' => $request->pilTipe,
                'id_satuan' => $request->pilSatuan,
                'nama_kpi' => $request->inpKPI,
                'formula_hitung' => $request->inpFormula,
                'data_pendukung' => $request->inpLaporan,
                'bobot_kpi' => $request->inpBobot
            ];
            KPIMasterModel::create($data);
            return redirect('hrd/setup/kpi')->with('konfirm', 'Data berhasil disimpan');
        } catch (Throwable $e) {
            Log::error('Transaction failed: '.$e->getMessage());
            return redirect('hrd/setup/kpi')->with('konfirm', 'Terdapat error pada proses penyimpanan data. error: '.$e->getMessage());
        }
    }
    public function kpi_departemen_edit($id)
    {
        $data = [
            'res' => KPIMasterModel::with([
                'departemen'
            ])->find($id),
            'allTipe' => KPITipeModel::where('active', 1)->get(),
            'allSatuan' => KPISatuanModel::where('active', 1)->get(),
        ];
        return view('HRD.setup.kpi.edit', $data);
    }

    public function kpi_departemen_update(Request $request, $id)
    {
        try
        {
             $data = [
                'id_tipe' => $request->pilTipe,
                'id_satuan' => $request->pilSatuan,
                'nama_kpi' => $request->inpKPI,
                'formula_hitung' => $request->inpFormula,
                'data_pendukung' => $request->inpLaporan,
                'bobot_kpi' => $request->inpBobot
            ];
            KPIMasterModel::find($id)->update($data);
            return redirect('hrd/setup/kpi')->with('konfirm', 'Perubahan data berhasil disimpan');
        } catch (Throwable $e) {
            Log::error('Transaction failed: '.$e->getMessage());
            return redirect('hrd/setup/kpi')->with('konfirm', 'Terdapat error pada proses penyimpanan data. error: '.$e->getMessage());
        }
    }

    public function kpi_departemen_hapus($id)
    {
        $checkExists = KPIPeriodikDetailModel::where('id_kpi', $id)->count();
        if($checkExists == 0) {
            KPIMasterModel::find($id)->delete();
            return redirect('hrd/setup/kpi')->with('konfirm', 'Data berhasil dihapus');
        } else {
            return redirect('hrd/setup/kpi')->with('konfirm', 'Data gagal dihapus. KPI telah digunakan');
        }

    }
}
