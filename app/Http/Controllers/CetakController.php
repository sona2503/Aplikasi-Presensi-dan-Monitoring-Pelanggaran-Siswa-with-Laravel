<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CetakController extends Controller
{
    //fungsi untuk mencetak laporan pelanggaran
    public function CetakPelanggaran($nisn){

        $nama = DB::table('siswa')->where('nisn', $nisn)->value('nama');

        $data = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.waktu', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point')
        ->where('pelanggaran.nisn', $nisn)
        ->get()
        ->toArray();

        $siswa = DB::table('kelas')
        ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
        ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
        ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
        ->where('siswa.nisn', $nisn)
        ->get();

        $pelanggaran = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.waktu', 'jenis_pelanggaran.jenis', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point')
        ->where('pelanggaran.nisn', $nisn)
        ->get();

    $totalPoint = $pelanggaran->sum('point');

    $pdf = Pdf::loadView('cetak/laporan', ['data' => $data, 'nama' => $nama, 'siswa' => $siswa, 'totalPoint' => $totalPoint]);

    return $pdf->stream('laporan.pdf');

    }

    public function CetakPresensi(Request $request, $nisn) {
        // Ambil nama siswa berdasarkan NISN
        $nama = DB::table('siswa')->where('nisn', $nisn)->value('nama');
        
        // Ambil detail siswa
        $siswa = DB::table('kelas')
            ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
            ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
            ->where('siswa.nisn', $nisn)
            ->get();
    
        // Ambil data bulan dari request (jika ada)
        $bulan = $request->input('bulan');
    
        // Ambil data presensi, filter berdasarkan bulan jika bulan dipilih
        $presensi = DB::table('presensi')
            ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
            ->select('presensi.tanggal', 'presensi.nisn', 'siswa.nama', 'presensi.status')
            ->where('siswa.nisn', $nisn)
            ->when($bulan, function ($query) use ($bulan) {
                return $query->whereMonth('presensi.tanggal', $bulan);
            })
            ->get();
    
        // Buat PDF dengan data yang sudah difilter
        $pdf = Pdf::loadView('cetak/presensi', ['siswa' => $siswa, 'presensi' => $presensi, 'nama' => $nama]);
    
        return $pdf->stream('laporan.pdf');
    }
    
    

    public function CetakPelanggaranOrtu(){

        $nisn = Auth::user()->nisn;

        $nama = DB::table('siswa')->where('nisn', $nisn)->value('nama');

        $data = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.waktu', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point')
        ->where('pelanggaran.nisn', $nisn)
        ->get()
        ->toArray();

        $siswa = DB::table('kelas')
        ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
        ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
        ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
        ->where('siswa.nisn', $nisn)
        ->get();

        $pelanggaran = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.waktu', 'jenis_pelanggaran.jenis', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point')
        ->where('pelanggaran.nisn', $nisn)
        ->get();

$totalPoint = $pelanggaran->sum('point');
// Cek apakah total point mencapai batas


        $pdf = Pdf::loadView('cetak/laporanortu', ['data' => $data, 'nama' => $nama, 'siswa' => $siswa, 'totalPoint' => $totalPoint]);

        return $pdf->stream('laporan.pdf');


    }

    public function CetakPresensiOrtu(Request $request){


    // Ambil bulan yang dipilih dari request
     $bulan = $request->input('bulan');

        // Mendapatkan pengguna yang sedang login
    $user = Auth::user();

    // Mengambil nilai nisn dari pengguna yang sedang login
    $nisn = $user->nisn;

    $nama = DB::table('siswa')->where('nisn', $nisn)->value('nama');

    // Ambil data siswa berdasarkan NISN
    $siswa = DB::table('kelas')
    ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
    ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
    ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
    ->where('siswa.nisn', $nisn)
    ->get();

 

    // Ambil data presensi berdasarkan bulan yang dipilih dan siswa
    $presensi = DB::table('presensi')
    ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
    ->select('presensi.tanggal', 'presensi.nisn', 'siswa.nama', 'presensi.status')
    ->where('siswa.nisn', $nisn)
    ->when($bulan, function ($query) use ($bulan) {
            return $query->whereMonth('presensi.tanggal', $bulan);
        })
    ->get();



    $pdf = Pdf::loadView('cetak/presensiortu', ['siswa' => $siswa, 'presensi' => $presensi, 'nama' => $nama]);

    return $pdf->stream('laporan.pdf');



    }
}
