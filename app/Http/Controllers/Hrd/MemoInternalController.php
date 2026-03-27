<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\HRD\MemoModel;
use App\Models\HRD\DepartemenModel;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
//use Image;
use File;

class MemoInternalController extends Controller
{
    public function index()
    {
        $data['list_memo'] = MemoModel::where('status', 1)->get();
        $data['list_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.setup.memo_internal.index', $data);
    }
    public function simpan(Request $request)
    {
        $path = storage_path("app/public/memo_internal");
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('memo_internal');
        }

        $image = $request->file('inp_file');
        $extension = $image->getClientOriginalExtension();
        $filename = time().date('dmY').".".$extension;
        $image_resize = Image::make($image->getRealPath());
        $image_resize->save(storage_path("app/public/memo_internal/".$filename));

        //$image_resize->save(public_path().'/upload/memo/'.$filename, 60);
        MemoModel::create([
            'tgl_post' => date('Y-m-d'),
            'judul' => $request->tgl_judul,
            'deskripsi' => $request->keterangan,
            'departemen_post' => $request->pil_penerbit,
            'file_memo' => $filename,
            'status' => 1,
            'id_user' => auth()->user()->id
        ]);
        return redirect('hrd/setup/memointernal')->with('konfirm', 'Memo Internal berhasil disimpan.');
    }
    public function edit($id)
    {
        $data['dtmemo'] = MemoModel::find($id);
        $data['list_departemen'] = DepartemenModel::where('status', 1)->get();
        return view('HRD.setup.memo_internal.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $path = storage_path("app/public/memo_internal");
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory('memo_internal');
        }
        if($request->hasFile('inp_file'))
        {
            $this->del_image_file($id);
            $image = $request->file('inp_file');
            $extension = $image->getClientOriginalExtension();
            $filename = time().date('dmY').".".$extension;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save(storage_path("app/public/memo_internal/".$filename));

            //$image_resize->save(public_path().'/upload/memo/'.$filename, 60);
            $update = MemoModel::find($id);
            $update->judul = $request->inp_judul;
            $update->deskripsi = $request->keterangan;
            $update->departemen_post = $request->pil_penerbit;
            $update->status = $request->pil_status;
            $update->file_memo = $filename;
            $update->save();
        } else {
            $update = MemoModel::find($id);
            $update->judul = $request->inp_judul;
            $update->deskripsi = $request->keterangan;
            $update->departemen_post = $request->pil_penerbit;
            $update->status = $request->pil_status;
            $update->save();
        }
        return redirect('hrd/setup/memointernal')->with('konfirm', 'Perubahan Data Memo Internal berhasil disimpan.');
    }
    public function delete($id)
    {
        $this->del_image_file($id);
        $delete = MemoModel::find($id);
        $delete->delete();
        return redirect('hrd/setup/memointernal')->with('konfirm', 'Data Memo Internal berhasil dihapus.');
    }
    public function del_image_file($id)
    {
        $resfile = MemoModel::where('id', $id)->first();
        $filename = $resfile->file_memo;
        $image_path = storage_path('app/public/memo_internal/'.$filename);
        //$image_path = public_path().'/upload/memo/'.$filename;
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
    }
}
