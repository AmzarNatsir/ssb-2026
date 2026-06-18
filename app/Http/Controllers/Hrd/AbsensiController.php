<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Hrdhelper;
use App\Imports\AbsensiImport;
use App\Exports\AbsensiMonitoringExport;
use App\Models\HRD\DepartemenModel;
use App\Models\HRD\CutiModel;
use App\Models\HRD\IzinModel;
use App\Models\HRD\KaryawanModel;
use App\Models\HRD\PerdisModel;
use App\Models\HRD\SetupHariLiburModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AbsensiController extends Controller
{
    public function index()
    {
        $thn = date('Y');
        $bln = date('m');
        $data['jml_hari'] = Hrdhelper::tglAkhirBulan($thn, $bln);
        $data['all_departemen'] = DepartemenModel::with(['get_master_divisi'])->where('status', 1)->get();
        $data['ket_periode'] = \App\Helpers\Hrdhelper::get_nama_bulan($bln)." ".$thn;
        $data['list_bulan'] = Config::get("constants.bulan");
        return view("HRD.absensi.index", $data);
    }

    public function list_data(Request $request)
    {
        $id_dept = $request->id_dept;
        $thn = $request->pil_tahun;
        $bln = $request->pil_bulan;
        $tgl_libur = array();
        $result_hari_libur = SetupHariLiburModel::whereMonth('tanggal', $bln)->whereYear('tanggal', $thn)->orderBy('tanggal')->get();
        foreach($result_hari_libur as $lbr) {
            $tgl_libur[] = $lbr->tanggal;
        }
        $ket_periode = \App\Helpers\Hrdhelper::get_nama_bulan($bln)." ".$thn;
        $list_karyawan = KaryawanModel::wherein('id_status_karyawan', [1, 2, 3, 7])->where('id_departemen', $id_dept)->where('nik', '<>', '999999999')->orderBy('nik', 'asc')->get();
        // $thn = date('Y');
        // $bln = date('m');
        $jml_hari = Hrdhelper::tglAkhirBulan($thn, $bln);
        $jml_cols = $jml_hari + 10;
        $html = "";
        $html .= "<table class='table table-hover table-bordered dataTable dataTable-scroll-x tbl_asbensi' style='font-size: small;'><thead><tr>
        <th rowspan='2' style='text-align:center'>No</th>
        <th rowspan='2' style='text-align:center'>NIK</th>
        <th rowspan='2' style='text-align:center'>Karyawan</th>
        <th colspan=".$jml_hari." style='text-align:center'>Periode ".$ket_periode."</th>
        <th rowspan='2' style='text-align:center'>Total Hadir</th>
        <th rowspan='2' style='text-align:center'>Total Cuti</th>
        <th rowspan='2' style='text-align:center'>Total Izin</th>
        <th rowspan='2' style='text-align:center'>Total Perdis</th>
        <th rowspan='2' style='text-align:center'>Total Training</th>
        </tr>
        <tr>";
        for($col=1; $col<=$jml_hari; $col++)
        {
            $html .= "<th style='text-align:center'>$col</th>";
        }
        $html .="</tr>
        </thead>
        <tbody>";
        if($list_karyawan->count() <= 0) {
            $html .= "<tr>
            <td colspan='".$jml_cols."' style='text-align:center'>Data Not Found !</td>
            </tr>";
            // echo $html;
        } else {
            $nom=1;
            foreach($list_karyawan as $list)
            {
                $jam_ishoma_start = "11:00";
                $jam_ishoma_end = "14:00";
                $tot_hadir=0;
                $tot_cuti=0;
                $tot_izin=0;
                $tot_perdis=0;
                $tot_pelatihan=0;
                $html .= "<tr>
                <td style='text-align:center'>".$nom."</td>
                <td>".$list->nik."</td>
                <td><h5>".$list->nm_lengkap."</h5></td>";
                // <td>".$list->nm_lengkap."</td>";
                for($i=1; $i<=$jml_hari; $i++)
				{
                    $libur = 'n';
                    $jml_hadir=0;
                    $jml_cuti=0;
                    $jml_izin=0;
                    $jml_perdis=0;
                    $jml_pelatihan=0;
                    $day=sprintf("%02s", $i);
                    $filter_tanggal = $thn."-".$bln."-".$day;
                    $val_libur = Hrdhelper::isWeekend($filter_tanggal);
                    if($val_libur=='sunday') //$val_libur=='saturday' sabtu
                    {
                        $blok_wrn = "background-color: #A0A0A0";
                        $libur = 'y';
                        // $blok_wrn = "bgcolor='red'";
                    }
                    else
                    {
                        if (in_array($filter_tanggal, $tgl_libur))
                        {
                            $blok_wrn = "background-color: #CC0000"; // "btn-primary";
                            // $blok_wrn = "bgcolor='blue'";
                            $libur = 'y';
                        }
                        else
                        {
                            $blok_wrn = "";
                            //$tampil = "Tanpa Ket.";
                        }
                    }
                    //cek kehadiran
                    $ket_hadir_in = "";
                    $ket_ishoma_in = "";
                    $ket_hadir_out = "";
                    $ket_ishoma_out = "";
                    $jml_hadir = 0;
                    $res_attendance = DB::table('hrd_absensi as a')
                    ->select([
                        'a.nik_lama',
                        DB::raw("(
                            SELECT MIN(jam)
                            FROM hrd_absensi
                            WHERE nik_lama = a.nik_lama
                            AND tanggal = '$filter_tanggal'
                            AND status = 'C/Masuk'
                        ) as check_in"),
                        DB::raw("(
                            SELECT MIN(jam)
                            FROM hrd_absensi
                            WHERE nik_lama = a.nik_lama
                            AND tanggal = '$filter_tanggal'
                            AND status = 'C/Keluar'
                            AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end'
                        ) as ishoma_keluar"),
                        DB::raw("(
                            SELECT MAX(jam)
                            FROM hrd_absensi
                            WHERE nik_lama = a.nik_lama
                            AND tanggal = '$filter_tanggal'
                            AND status = 'C/Masuk'
                            AND jam BETWEEN '$jam_ishoma_start' AND '$jam_ishoma_end'
                        ) as ishoma_masuk"),
                        DB::raw("(
                            SELECT MAX(jam)
                            FROM hrd_absensi
                            WHERE nik_lama = a.nik_lama
                            AND tanggal = '$filter_tanggal'
                            AND status = 'C/Keluar'
                        ) as pulang")
                    ])
                    ->whereDate('a.tanggal', $filter_tanggal)
                    ->where('a.nik_lama', $list->nik_lama)
                    ->groupBy('a.nik_lama')
                    ->first();
                     if ($res_attendance) {
                        $in = (empty($res_attendance->check_in)) ? "" : date('H:i', strtotime($res_attendance->check_in));
                        $ishoma_out = (empty($res_attendance->ishoma_keluar)) ? "" : date('H:i', strtotime($res_attendance->ishoma_keluar));
                        $ishoma_in = (empty($res_attendance->ishoma_masuk)) ? "" : date('H:i', strtotime($res_attendance->ishoma_masuk));
                        $out = (empty($res_attendance->pulang)) ? "" : date('H:i', strtotime($res_attendance->pulang));

                        $ket_hadir_in = $in;
                        $ket_ishoma_out = (!empty($ishoma_out)) ? "-".$ishoma_out : "";
                        $ket_ishoma_in = (!empty($ishoma_in)) ? " | ".$ishoma_in. "-" : "";
                        $ket_hadir_out = $out;

                        $jml_hadir=1;
                    }

                    //Cek Cuti Karyawan
                    $result_cuti = CutiModel::where('id_karyawan', $list->id)
                                ->where('tgl_awal', '<=', $filter_tanggal)
                                ->where('tgl_akhir', '>=', $filter_tanggal)
                                ->where('sts_pengajuan', 2)->get()->count();
                    //Cek Izin Karyawan
                    $result_izin = IzinModel::where('id_karyawan', $list->id)
                                ->where('tgl_awal', '<=', $filter_tanggal)
                                ->where('tgl_akhir', '>=', $filter_tanggal)
                                ->where('sts_pengajuan', 2)->get()->count();
                    //Cek Perdis
                    $result_perdis = PerdisModel::where('id_karyawan', $list->id)
                                ->where('tgl_berangkat', '<=', $filter_tanggal)
                                ->where('tgl_kembali', '>=', $filter_tanggal)
                                ->where('sts_persetujuan', 1)->get()->count();
                    //Cek Pelatihan
                    $result_pelatihan = DB::table('hrd_pelatihan_h')
                                ->join('hrd_pelatihan_d', 'hrd_pelatihan_h.id', '=', 'hrd_pelatihan_d.id_head')
                                ->where('hrd_pelatihan_h.tanggal_awal', '<=', $filter_tanggal)
                                ->where('hrd_pelatihan_h.tanggal_sampai', '>=', $filter_tanggal)
                                ->where('hrd_pelatihan_d.id_karyawan', $list->id)
                                ->where('hrd_pelatihan_h.status_pelatihan', 5)->get()->count();
                    if($result_cuti >= 1) {
                        if($libur=='n')
                        {
                            $jml_cuti=1;
                            $html .= "<td style=".$blok_wrn."><button type='button' class='btn btn-info btn-block'>CUTI</button></td>";
                        } else {
                            $html .= "<td style=".$blok_wrn."></td>";
                        }

                    } else if ($result_izin >= 1) {
                        if($libur=='n')
                        {
                            $jml_izin=1;
                            $html .= "<td style=".$blok_wrn."><button type='button' class='btn btn-info btn-block'>IZIN</button></td>";
                        } else {
                            $html .= "<td style=".$blok_wrn."></td>";
                        }
                    } else if ($result_perdis >= 1) {
                        if($libur=='n')
                        {
                            $jml_perdis=1;
                            $html .= "<td style=".$blok_wrn."><button type='button' class='btn btn-info btn-block'>Perjalanan Dinas</button></td>";
                        } else {
                            $html .= "<td style=".$blok_wrn."></td>";
                        }
                    } else if ($result_pelatihan >= 1) {
                        if($libur=='n')
                        {
                            $jml_pelatihan=1;
                            $html .= "<td style=".$blok_wrn."><button type='button' class='btn btn-info btn-block'>Traning</button></td>";
                        } else {
                            $html .= "<td style=".$blok_wrn."></td>";
                        }

                    } else {
                        // Format jadwal dengan style modern (Opsi 4)
                        $jadwal_html = $this->formatJadwalModern($ket_hadir_in, $ket_ishoma_out, $ket_ishoma_in, $ket_hadir_out, $filter_tanggal);
                        $html .= "<td class='text-center' style='".$blok_wrn."'>".$jadwal_html."</td>";
                    }

                    // $html .= "<td style='".$blok_wrn."'>".$ket_hadir_in.$ket_hadir_out."</td>";

                    $tot_hadir+=$jml_hadir;
                    $tot_cuti+=$jml_cuti;
                    $tot_izin+=$jml_izin;
                    $tot_perdis+=$jml_perdis;
                    $tot_pelatihan+=$jml_pelatihan;
                }
                $html .= "<td style='text-align:center'><b>".$tot_hadir."</b></td>";
                $html .= "<td style='text-align:center'><b>".$tot_cuti."</b></td>";
                $html .= "<td style='text-align:center'><b>".$tot_izin."</b></td>";
                $html .= "<td style='text-align:center'><b>".$tot_perdis."</b></td>";
                $html .= "<td style='text-align:center'><b>".$tot_pelatihan."</b></td>";
                $html .= "</tr>";
                $nom++;
            }
        }
        $html .="
        </tbody>
        </table>";
        echo $html;
    }

    public function export_excel($id_dept, $bulan, $tahun)
    {
        return (new AbsensiMonitoringExport($id_dept, $bulan, $tahun))
            ->download('monitoring-absensi-' . $bulan . '-' . $tahun . '.xlsx');
    }

    public function import_data_absensi()
    {
        // $data['all_departemen'] = DepartemenModel::where('status', 1)->get();
        return view("HRD.absensi.frmimport");
    }

    public function previewImportAbsensi(Request $request)
    {
        $request->validate([
            'file_imp' => 'required|mimes:xlsx,csv,xls'
        ]);

        if (!$request->hasFile('file_imp')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang dikirim.'
            ], 400);
        }

        try {
            $file = $request->file('file_imp');
            $extension = strtolower($file->getClientOriginalExtension());

            // Move file to temp directory
            $fileName = 'import_absensi_' . time() . '.' . $extension;
            $tempPath = storage_path('app/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            $file->move($tempPath, $fileName);
            $fullPath = $tempPath . DIRECTORY_SEPARATOR . $fileName;

            if (!file_exists($fullPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca file: File gagal dipindahkan ke direktori sementara.'
                ]);
            }

            // Load spreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fullPath);
            $firstSheet = $spreadsheet->getSheet(0);
            $sheetData = $firstSheet->toArray();

            // Skip header dan filter data kosong
            $dataRows = array_slice($sheetData, 1);
            $dataRows = array_filter($dataRows, function($row) {
                return !empty(array_filter($row));
            });

            if (count($dataRows) <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'File Excel tidak berisi data.'
                ]);
            }

            // Ambil maksimal 5 baris untuk preview
            $previewRows = array_slice($dataRows, 0, 5);
            $processedRows = [];
            $totalRows = count($dataRows);
            $errorCount = 0;

            foreach ($previewRows as $row) {
                // Struktur kolom: tanggal_scan, tanggal, jam, nik_lama, i_o, lokasi_id, dhuhur, ashar
                $tanggal_scan = $row[0] ?? ''; // Kolom A
                $tanggal = $row[1] ?? ''; // Kolom B
                $jam = $row[2] ?? ''; // Kolom C
                $nik_lama = $row[3] ?? ''; // Kolom D
                $io = $row[4] ?? ''; // Kolom E

                $errors = [];

                // Handle numeric dates from Excel (tanggal_scan) - no validation needed
                if (is_numeric($tanggal_scan)) {
                    try {
                        $tanggal_scan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_scan)->format('Y-m-d');
                    } catch (\Exception $e) {}
                }

                // Handle numeric dates from Excel (tanggal)
                if (is_numeric($tanggal)) {
                    try {
                        $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
                    } catch (\Exception $e) {}
                }

                // Handle numeric time values from Excel (stored as decimal fraction of day)
                if (is_numeric($jam)) {
                    try {
                        $timeValue = floatval($jam);
                        if ($timeValue > 0 && $timeValue < 1) {
                            $seconds = $timeValue * 86400; // 24 * 60 * 60
                            $hours = intval($seconds / 3600);
                            $minutes = intval(($seconds % 3600) / 60);
                            $jam = sprintf('%02d:%02d', $hours, $minutes);
                        }
                    } catch (\Exception $e) {}
                }

                // Validasi tanggal format YYYY-MM-DD
                if (empty($tanggal)) {
                    $errors[] = 'Tanggal kosong';
                } else {
                    $d = \DateTime::createFromFormat('Y-m-d', $tanggal);
                    if (!$d || $d->format('Y-m-d') !== $tanggal) {
                        $errors[] = 'Format tanggal harus yyyy-mm-dd';
                    }
                }

                // Validasi jam format HH:MM
                if (empty($jam)) {
                    $errors[] = 'Jam kosong';
                } else {
                    $t = \DateTime::createFromFormat('H:i', $jam);
                    if (!$t || $t->format('H:i') !== $jam) {
                        $errors[] = 'Format jam harus hh:mm';
                    }
                }

                // Validasi NIK
                if (empty($nik_lama)) {
                    $errors[] = 'NIK kosong';
                }

                // Validasi I/O
                if (empty($io)) {
                    $errors[] = 'I/O kosong';
                }

                if (!empty($errors)) {
                    $errorCount++;
                }

                $processedRows[] = [
                    'nik_lama' => $nik_lama,
                    'tanggal_scan' => $tanggal_scan,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'io' => $io,
                    'status' => $io === 'C/Masuk' ? 'Masuk' : ($io === 'C/Keluar' ? 'Keluar' : $io),
                    'valid' => empty($errors),
                    'errors' => $errors
                ];
            }

            return response()->json([
                'success' => true,
                'preview' => $processedRows,
                'totalRows' => $totalRows,
                'errorCount' => $errorCount,
                'message' => "Preview data (menampilkan 5 baris dari $totalRows total baris)"
            ]);
        } catch (Throwable $e) {
            Log::error('Preview failed: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error membaca file: ' . $e->getMessage()
            ]);
        }
    }

    public function doImportAbsensi(Request $request)
    {
        $request->validate([
            'file_imp' => 'required|mimes:xlsx,csv,xls'
        ]);

        if (!$request->hasFile('file_imp')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang dikirim.'
            ], 400);
        }

        try {
            $file = $request->file('file_imp');
            $extension = strtolower($file->getClientOriginalExtension());

            // Validasi nama file (opsional, sesuai template)
            $filename = $file->getClientOriginalName();
            if (!str_contains($filename, 'templateAbsensiKaryawan')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama file tidak sesuai dengan template. Pastikan nama file mengandung "templateAbsensiKaryawan".'
                ]);
            }

            // Move file to temp directory
            $fileName = 'import_absensi_' . time() . '.' . $extension;
            $tempPath = storage_path('app/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            $file->move($tempPath, $fileName);
            $fullPath = $tempPath . DIRECTORY_SEPARATOR . $fileName;

            if (!file_exists($fullPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca file: File gagal dipindahkan ke direktori sementara.'
                ]);
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fullPath);
            $firstSheet = $spreadsheet->getSheet(0);
            $sheetData = $firstSheet->toArray();

            // Buang baris kosong total
            $dataRows = array_filter($sheetData, function($row) {
                return !empty(array_filter($row)); // at least one non-empty cell
            });

            if (count($dataRows) <= 1) {
                @unlink($fullPath);
                return response()->json([
                    'success' => false,
                    'message' => 'File Excel tidak berisi data.'
                ]);
            }

            DB::beginTransaction();
            try {
                $import = new AbsensiImport(false);
                Excel::import($import, $fullPath);

                if (!$import->isAllValid()) {
                    DB::rollBack();
                    $rs = response()->json([
                        'success' => false,
                        'message' => $import->getErrors()
                    ]);
                } else {
                    // ✅ Validasi tanggal duplikat
                    $existingDates = $import->getValidationDate();
                    if (count($existingDates) > 0) {
                        DB::rollBack();
                        $rs = response()->json([
                            'success' => false,
                            'message' => 'Tanggal berikut sudah ada: ' . implode(', ', $existingDates)
                        ]);
                    } else {
                        // ✅ Semua valid, simpan ke DB
                        $import->saveAllToDB();
                        DB::commit();
                        $rs = response()->json([
                            'success' => true,
                            'message' => "Import data absensi karyawan berhasil.",
                        ]);
                    }
                }
            } catch (Throwable $e) {
                DB::rollBack();
                Log::error('Import failed: '.$e->getMessage());
                $rs = response()->json([
                    'success' => false,
                    'message' => "Terdapat error pada proses import data. error: ".$e->getMessage()
                ]);
            } finally {
                // Clean up temp file
                @unlink($fullPath);
            }

            return $rs;
        } catch (Throwable $e) {
            Log::error('Import failed: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error membaca file: ' . $e->getMessage()
            ]);
        }
    }

    private function formatJadwalModern($masuk, $ishoma_keluar, $ishoma_masuk, $pulang, $tanggal)
    {
        if (empty($masuk) && empty($pulang)) {
            return '';
        }

        $jam_masuk = $masuk;
        $jam_pulang = $pulang;
        $jam_ishoma_masuk = str_replace(' | ', '', $ishoma_masuk);
        $jam_ishoma_keluar = str_replace('-', '', $ishoma_keluar);

        $html = '<div class="schedule-card">';

        if (!empty($jam_masuk)) {
            $html .= '<div class="schedule-shift">';
            $html .= '<span class="shift-badge pagi">🟦</span>';
            $html .= '<span class="shift-label">Pagi:</span>';
            $html .= '<span class="shift-time">' . $jam_masuk . '-' . $jam_ishoma_keluar . '</span>';

            if (!empty($jam_ishoma_keluar)) {
                $durasi = $this->hitungDurasi($jam_masuk, $jam_ishoma_keluar);
                $html .= '<span class="shift-duration">(' . $durasi . 'h)</span>';
            }
            $html .= '</div>';
        }

        if (!empty($jam_ishoma_masuk) && !empty($jam_pulang)) {
            $html .= '<div class="schedule-shift">';
            $html .= '<span class="shift-badge siang">🟩</span>';
            $html .= '<span class="shift-label">Siang:</span>';
            $html .= '<span class="shift-time">' . $jam_ishoma_masuk . '-' . $jam_pulang . '</span>';

            $durasi = $this->hitungDurasi($jam_ishoma_masuk, $jam_pulang);
            $html .= '<span class="shift-duration">(' . $durasi . 'h)</span>';
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    private function hitungDurasi($jam_mulai, $jam_akhir)
    {
        try {
            $mulai = \DateTime::createFromFormat('H:i', $jam_mulai);
            $akhir = \DateTime::createFromFormat('H:i', $jam_akhir);

            if ($mulai && $akhir) {
                $diff = $akhir->diff($mulai);
                return $diff->h;
            }
        } catch (\Exception $e) {
            return '';
        }
    }
}
