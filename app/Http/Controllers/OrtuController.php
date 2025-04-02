<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrtuController extends Controller
{
    //tampilan awal
    public function TampilanAwalOrtu(){

        return view('sidebarortu');
    }

    public function LihatAbsenOrtu(Request $request){

    //mengambil data bulan dari view
    $bulan = $request->input('bulan');

    // Mendapatkan pengguna yang sedang login
    $user = Auth::user();

    // Mengambil nilai nisn dari pengguna yang sedang login
    $nisn = $user->nisn;

    // Ambil data siswa berdasarkan NISN
     $siswa = DB::table('siswa')
        ->where('nisn', $nisn )
        ->first();

        $presensi = DB::table('presensi')
        ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
        ->select('presensi.tanggal', 'presensi.nisn', 'siswa.nama', 'presensi.status')
        ->where('siswa.nisn', $nisn)
        ->when($bulan, function ($query) use ($bulan) {
            return $query->whereMonth('presensi.tanggal', $bulan);
        })
        ->get();

    $data = DB::table('kelas')
    ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
    ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
    ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
    ->where('siswa.nisn', $nisn)
    ->get();



        return view('ortu/presensi',['presensi' => $presensi, 'siswa' => $siswa, 'data' => $data]);
    }

    public function LihatPelanggaranOrtu(){

    // Mendapatkan pengguna yang sedang login
    $user = Auth::user();

    // Mengambil nilai nisn dari pengguna yang sedang login
    $nisn = $user->nisn;

    // Ambil data siswa berdasarkan NISN
    $siswa = DB::table('siswa')
        ->where('nisn', $nisn )
        ->first();

    $pelanggaran = DB::table('pelanggaran')
    ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
    ->select('pelanggaran.waktu', 'jenis_pelanggaran.jenis', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point')
    ->where('pelanggaran.nisn', $nisn)
    ->get();

// Menghitung total poin
$totalPoint = $pelanggaran->sum('point');
// Cek apakah total point mencapai batas
if ($totalPoint > 0 && $totalPoint % 10 == 0) {
    session()->flash('warning', 'Dengan segala Hormat kami mengabarkan bahwa ananda '. $siswa->nama .  
                    ' sudah mencapai point maksimal pelanggaran. dan kiranya Bpk/Ibu berkenan datang ke Sekolah. Hormat Kami.');
}

    $data = DB::table('kelas')
    ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
    ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
    ->select('guru.nama_guru', 'kelas.kelas', 'siswa.nama', 'siswa.nisn')
    ->where('siswa.nisn', $nisn)
    ->get();

        return view('ortu/pelanggaran', ['pelanggaran' => $pelanggaran, 'siswa' => $siswa, 'data' => $data, 'totalPoint' => $totalPoint, ]);
    }
}
