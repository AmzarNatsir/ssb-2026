<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HasUpload
{
    public function uploadImage($request, $path, $directory)
    {
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory($directory);
        }
        $image = null;
        if($request->file('inpFileImage')) {
            $image = $request->file('inpFileImage');
            $image->storeAs($path, $image->hashName());
        }

        return $image;
    }

    public static function makeFolder($folder)
    {
        $path = storage_path("app/public/".$folder);
        if(!File::isDirectory($path)) {
            $path = Storage::disk('public')->makeDirectory($folder);
        }
    }

    public static function uploadFile($file, $filelocation)
    {
        $tujuan_upload  = 'public/'.$filelocation;

        // $file = $request->file('inp_file');
        // $filename = time() . '_' . $file->getClientOriginalName();
        // $path = $file->storeAs($tujuan_upload, $filename);


        $path = Storage::putFile(
            $tujuan_upload,
            $file
        );

        $filenameupload = $tujuan_upload."/".basename($path);

        return $filenameupload;
    }

    public static function hapusFile($file)
    {
        if ($file && Storage::disk('public')->exists($file)) {
            return Storage::disk('public')->delete($file); // return true/false
        }
        return false;
    }

    public static function handleFileUpload($request, $fileKey, $tmpKey, $folder)
    {
        HasUpload::makeFolder($folder);
        if ($request->hasFile($fileKey)) {
            if (!empty($tmpKey)) {
                HasUpload::hapusFile($tmpKey);
            }
            return HasUpload::uploadFile($request->file($fileKey), $folder);
        }
        return (!empty($tmpKey)) ? $tmpKey : null;
    }

}
