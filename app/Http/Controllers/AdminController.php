<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //tampilan awal admin
    public function TampilanAwal(){

        return view('sidebaradmin');
    }

    public function PilihKelasAbsensiAdm(){

        $kelas = DB::table('kelas')
        ->select('id_kelas','kelas')
        ->get();
        
      return view('admin/pilihkelasabsen', ['kelas' => $kelas]);
    }

    public function LihatAbsenAdm(Request $request, $id)
    {
        // Ambil data kelas untuk judul
        $kelas = DB::table('kelas')
            ->select('kelas', 'id_kelas')
            ->where('kelas.id_kelas', $id)
            ->first();
    
        // Query dasar untuk data presensi
        $presensiQuery = DB::table('presensi')
            ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
            ->select('presensi.tanggal', 'presensi.nisn', 'siswa.nama', 'presensi.status')
            ->where('presensi.id_kelas', $id);
    
        // Tambahkan filter berdasarkan bulan jika ada
        if ($request->filled('bulan')) {
            $presensiQuery->whereMonth('presensi.tanggal', $request->bulan);
        }
    
        // Eksekusi query
        $presensi = $presensiQuery->get();
    
        // Return view dengan data presensi dan kelas
        return view('admin.lihatabsen', ['presensi' => $presensi, 'kelas' => $kelas]);
    }
    

    public function TampilPelanggaranAdm(Request $request){

      // Ambil data kelas untuk dropdown
      $kelas = DB::table('kelas')->select('id_kelas', 'kelas')->get();

      // Query untuk mengambil data pelanggaran
      $pelanggaranQuery = DB::table('pelanggaran')
          ->join('siswa', 'pelanggaran.nisn', '=', 'siswa.nisn')
          ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
          ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
          ->select('kelas.kelas', 'siswa.nisn', 'siswa.nama', 'jenis_pelanggaran.pelanggaran', 'jenis_pelanggaran.jenis');
      
      // Filter berdasarkan kelas jika ada
      if ($request->has('id_kelas') && $request->id_kelas != '') {
          $pelanggaranQuery->where('kelas.id_kelas', $request->id_kelas);
      }
  
      // Ambil hasil query setelah pengecekan filter
      $pelanggaran = $pelanggaranQuery->get();
  

        
      return view('admin/tampilpelanggaran', ['pelanggaran' => $pelanggaran, 'kelas' => $kelas]);
    }

    public function TampilKelasAdm(){

      $kelas = DB::table('kelas')
      ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
      ->select('kelas.id_kelas', 'kelas.kelas', 'periode.periode')
      ->get();

      $periode = DB::table('periode')->max('periode');


      return view('admin/tampilkelas', ['kelas' => $kelas, 'periode' => $periode]);

    }

    public function TambahKelasAdm(){

      $select = DB::table('periode')
        ->select('id_periode','periode')
        ->get();

      return view('admin/tambahkelas', ['select' => $select]);
    }

    public function TambahKelasAction(Request $request){

            // Validasi input
            $request->validate([
                'id_periode' => 'required',
                'kelas' => 'required|string',
            ]);
        
        
            // Memasukkan data ke dalam tabel 'kelas'
            DB::table('kelas')->insert([
                'id_periode' => $request->id_periode, 
                'kelas' => $request->kelas,
            ]);

          // Redirect ke route 'TampilKelasAdm' dengan pesan sukses
    return redirect()->route('TampilKelasAdm')->with('success', 'Kelas berhasil ditambahkan!');

    }

    public function HapusKelas($id_kelas) {
      // Menghapus data kelas berdasarkan id_kelas
      DB::table('kelas')->where('id_kelas', $id_kelas)->delete();
  
      // Redirect ke halaman daftar kelas dengan pesan error
      return redirect()->route('TampilKelasAdm')->with('danger', 'Data Kelas berhasil dihapus!');
  }

  public function EditKelas($id_kelas) {
    // Ambil data kelas berdasarkan id_kelas
    $kelas = DB::table('kelas')
        ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
        ->select('kelas.id_kelas', 'kelas.kelas', 'periode.periode', 'kelas.id_periode') 
        ->where('kelas.id_kelas', $id_kelas)
        ->first(); 

    // Ambil daftar periode
    $periode = DB::table('periode')
        ->select('id_periode','periode')
        ->get();

    return view('admin/editkelas', ['kelas' => $kelas, 'periode' => $periode]);
}


public function UpdateKelasAction(Request $request) {
  // Validasi input
  $request->validate([
      'id_periode' => 'required',
      'kelas' => 'required|string',
  ]);

  // Update data di tabel 'kelas'
  DB::table('kelas')
      ->where('id_kelas', $request->id_kelas)
      ->update([
          'id_periode' => $request->id_periode,
          'kelas' => $request->kelas,
      ]);

  // Redirect ke route 'TampilKelasAdm' dengan pesan sukses
  return redirect()->route('TampilKelasAdm')->with('success', 'Data Kelas berhasil diubah!');
}



  public function TambahPeriodeAdm(){

    return view('admin/tambahperiode');

  }

  public function TambahPeriodeAction(Request $request) {
    // Validasi input
    $request->validate([
        'periode' => 'required|string',
    ]);

    // Memasukkan data ke dalam tabel 'periode'
    DB::table('periode')->insert([
        'periode' => $request->periode,
    ]);

    // Redirect ke route 'TampilKelasAdm' dengan pesan sukses
    return redirect()->route('TampilKelasAdm')->with('success', 'Tahun Ajaran berhasil ditambahkan!');
}

public function TampilGuruAdm(){

  $guru = DB::table('kelas')
    ->join('guru', 'kelas.id_kelas', '=', 'guru.id_kelas')
    ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
    ->select('guru.nip', 'guru.nama_guru', 'kelas.kelas', 'periode.periode')
    ->get();


  return view('admin/tampilguru', ['guru' => $guru]);
}

public function TambahGuruAdm(){

  $select = DB::table('kelas')
    ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
    ->select('kelas.id_kelas', 'kelas.kelas', 'periode.periode')
    ->get();

  return view('admin/tambahguru', ['select' => $select]);
}

public function TambahGuruAction(Request $request){

          // Validasi input
            $request->validate([
                'nip' => 'required',
                'id_kelas' => 'required',
                'nama_guru' => 'required|string',
                'no_telp' => 'required|string',
                'alamat' => 'required|string',
            ]);
        
        
            // Memasukkan data ke dalam tabel 'kelas'
            DB::table('guru')->insert([
                'nip' => $request->nip, 
                'id_kelas' => $request->id_kelas, 
                'nama_guru' => $request->nama_guru,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
            ]);

          // Redirect ke route 'TampilKelasAdm' dengan pesan sukses
    return redirect()->route('TampilGuruAdm')->with('success', 'Data Guru berhasil ditambahkan!');


}

public function HapusGuru($nip){

        // Menghapus data kelas berdasarkan id_kelas
        DB::table('guru')->where('nip', $nip)->delete();
  
        // Redirect ke halaman daftar kelas dengan pesan error
        return redirect()->route('TampilGuruAdm')->with('danger', 'Data Guru berhasil dihapus!');

}

public function EditGuru($nip){

  // Ambil data guru berdasarkan id_kelas
  $guru = DB::table('guru')
  ->join('kelas', 'guru.id_kelas', '=', 'kelas.id_kelas')
  ->select('guru.id_kelas', 'guru.nip', 'kelas.kelas', 'guru.nama_guru', 'guru.no_telp', 'guru.alamat')
  ->where('guru.nip', $nip)
  ->first(); 

  // Ambil daftar periode
  $select = DB::table('kelas')
  ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
  ->select('kelas.id_kelas', 'kelas.kelas', 'periode.periode')
  ->get();
  


  return view('admin/editguru', ['guru' => $guru, 'select' => $select]);


}

public function UpdateGuruAction(Request $request) {
  // Validasi input
  $request->validate([
      'nip' => 'required', 
      'old_nip' => 'required', 
      'id_kelas' => 'required',
      'nama_guru' => 'required|string',
      'no_telp' => 'required|string',
      'alamat' => 'required|string',
  ]);

  // Update data di tabel 'guru' berdasarkan NIP lama
  DB::table('guru')
      ->where('nip', $request->old_nip)
      ->update([
          'nip' => $request->nip, 
          'id_kelas' => $request->id_kelas,
          'nama_guru' => $request->nama_guru,
          'no_telp' => $request->no_telp,
          'alamat' => $request->alamat,
      ]);

  // Redirect ke route 'TampilGuruAdm' dengan pesan sukses
  return redirect()->route('TampilGuruAdm')->with('success', 'Data Guru berhasil diubah!');
}

public function TampilUserAdm(){

  $users = DB::table('users')
    ->join('roles', 'users.id_role', '=', 'roles.id_role')
    ->select('users.id_user', 'users.user', 'roles.role')
    ->orderBy('users.id_role', 'asc')
    ->get();

  return view('admin/tampiluser', ['users' => $users]);
}

public function TambahUserAdm(){

  $roles = DB::table('roles')
            ->select('id_role', 'role')
            ->get();


  return view('admin/tambahuser',['roles' => $roles]);
}

public function HapusUser($id){

    // Menghapus data user berdasarkan id
    DB::table('users')->where('id_user', $id)->delete();
  
    // Redirect ke halaman daftar users dengan pesan error
    return redirect()->route('TampilUserAdm')->with('danger', 'Data User berhasil dihapus!');

}

//fungsi untuk menampilkan analisa dengan diagram

public function Analisa(){

  $data = DB::table('pelanggaran')
        ->join('siswa', 'pelanggaran.nisn', '=', 'siswa.nisn')
        ->leftJoin('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
        ->select('kelas.id_kelas', 'kelas.kelas', DB::raw('COUNT(pelanggaran.id_pelanggaran) as total_pelanggaran'))
        ->groupBy('kelas.id_kelas')
        ->get();

  
  
  return view('admin/analisa', ['data' => $data]);
}



}

  



