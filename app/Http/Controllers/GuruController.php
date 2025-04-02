<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GuruController extends Controller
{
    //tampilan awal
    public function TampilanAwalGuru(){

        return view('sidebarguru');
    }

    public function PilihKelas(){

        $kelas = DB::table('kelas')
           ->select('id_kelas','kelas')
           ->get();

        return view('guru/pilihkelas', ['kelas' => $kelas]);
    }

    public function TampilSiswa($id){
        
        $kelas = DB::table('kelas')
        ->select('kelas')
        ->where('id_kelas', $id)
        ->first();

        $siswa = DB::table('siswa')
        ->select('nisn', 'nama')
        ->where('id_kelas', $id)
        ->get();

        return view('guru/tampilsiswa', ['siswa' => $siswa, 'kelas' => $kelas, 'id' => $id]);

    }

    public function TambahSiswa($id){

        return view('guru/tambahsiswa', ['id' => $id]);
    }

    public function TambahSiswaAction(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required',
            'nama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'id_kelas' => 'required', // Pastikan id_kelas divalidasi
        ]);
    
        // Mengambil id_kelas dari request
        $id_kelas = $request->input('id_kelas');
    
        // Memasukkan data ke dalam tabel 'siswa'
        DB::table('siswa')->insert([
            'nisn' => $request->nisn,
            'id_kelas' => $id_kelas,  
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);
    
        return redirect()->route('TampilSiswa', ['id' => $id_kelas])
        ->with('success', 'Data Siswa berhasil disimpan.');
    }

    public function HapusSiswa($id, $nisn){

        // Menghapus data kelas berdasarkan nisn
        DB::table('siswa')->where('nisn', $nisn)->delete();
  
        // Redirect ke halaman daftar siswa dengan pesan error
        return redirect()->route('TampilSiswa', ['id' => $id])->with('danger', 'Data Siswa berhasil dihapus!');

    }

    public function EditSiswa($nisn){

        $siswa = DB::table('siswa')
        ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
        ->select('siswa.id_kelas', 'siswa.nisn', 'kelas.kelas', 'siswa.nama', 'siswa.tempat_lahir', 'siswa.tanggal_lahir')
        ->where('siswa.nisn', $nisn)
        ->first();

          // Ambil daftar kelas untuk dropdown
    $select = DB::table('kelas')
    ->join('periode', 'kelas.id_periode', '=', 'periode.id_periode')
    ->select('kelas.id_kelas', 'kelas.kelas', 'periode.periode')
    ->get();

    return view('guru/editsiswa', ['siswa' => $siswa, 'select' => $select]);


    }

    

    public function UpdateSiswaAction(Request $request){

        // Validasi input
  $request->validate([
    'nisn' => 'required', 
    'old_nisn' => 'required', 
    'id_kelas' => 'required',
    'nama' => 'required|string',
    'tempat_lahir' => 'required|string',
    'tanggal_lahir' => 'required|date',
]);

// Update data di tabel 'guru' berdasarkan NIP lama
DB::table('siswa')
    ->where('nisn', $request->old_nisn)
    ->update([
        'nisn' => $request->nisn, 
        'id_kelas' => $request->id_kelas,
        'nama' => $request->nama,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
    ]);

// Redirect ke route 'TampilGuruAdm' dengan pesan sukses
return redirect()->route('TampilSiswa', ['id' => $request->id_kelas])->with('success', 'Data Siswa berhasil diubah!');


    }
    
    

    public function PilihKelasAbsensi(){
        
        $kelas = DB::table('kelas')
        ->select('id_kelas','kelas')
        ->get();
        
      return view('guru/pilihkelasabsen', ['kelas' => $kelas]);
    }

    public function TambahAbsen(){

    // Ambil user yang sedang login
     $user = Auth::user();
    
     // Ambil id_kelas berdasarkan NIP dari user yang login
     $id = DB::table('guru')
         ->join('users', 'users.nip', '=', 'guru.nip')
         ->where('users.id_user', $user->id_user)  // Menggunakan ID user yang login
         ->value('guru.id_kelas');  // Ambil nilai id_kelas

        $siswa = DB::table('siswa')
         ->select('nisn', 'nama')
         ->where('id_kelas', $id)
         ->get();

        $kelas = DB::table('kelas')
         ->select('kelas')
         ->where('id_kelas', $id)
         ->first();


        return view('guru/absen',['siswa' => $siswa, 'kelas' => $kelas, 'id' => $id]);
    }

    public function TambahAbsenAction(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_kelas' => 'required',
            'nisn' => 'required|array', 
            'status' => 'required|array', 
            'tanggal' => 'required|date',
        ]);
    
        // Loop melalui setiap siswa yang diabsen
        foreach ($request->nisn as $index => $nisn) {
            DB::table('presensi')->insert([
                'id_kelas' => $request->id_kelas, 
                'nisn' => $nisn, 
                'status' => $request->status[$index], 
                'tanggal' => $request->tanggal, // Tanggal absen
            ]);
        }
    
        return redirect()->back()->with('success', 'Absen berhasil disimpan untuk tanggal: ' . $request->tanggal);
    }

    public function LihatAbsen(Request $request){

    //ambil data bulan 
    $bulan = $request->input('bulan');

    // Ambil user yang sedang login
     $user = Auth::user();
    
     // Ambil id_kelas berdasarkan NIP dari user yang login
     $id = DB::table('guru')
         ->join('users', 'users.nip', '=', 'guru.nip')
         ->where('users.id_user', $user->id_user)  // Menggunakan ID user yang login
         ->value('guru.id_kelas');  // Ambil nilai id_kelas

    // Query presensi
        $presensi = DB::table('presensi')
        ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
        ->select('presensi.tanggal', 'presensi.nisn', 'siswa.nama', 'presensi.status')
        ->where('presensi.id_kelas', $id)
        ->when($bulan, function ($query) use ($bulan) {
            return $query->whereMonth('presensi.tanggal', $bulan);
        })
        ->get();
        
        $kelas = DB::table('kelas')
        ->select('id_kelas', 'kelas')
        ->where('kelas.id_kelas', $id)
        ->first();

        return view('guru/lihatabsen',['presensi' => $presensi, 'kelas' => $kelas]);
   
    }

    public function EditPresensi($tanggal, $kelas_id)
    {
        // Ambil data presensi berdasarkan tanggal dan id kelas
        $presensi = DB::table('presensi')
        ->join('siswa', 'presensi.nisn', '=', 'siswa.nisn')
        ->select('presensi.id_presensi', 'presensi.nisn', 'siswa.nama', 'presensi.status')
        ->where('presensi.id_kelas', $kelas_id)
        ->where('presensi.tanggal', $tanggal)
        ->get();
    
        // Ambil detail kelas
        $kelas = DB::table('kelas')->where('id_kelas', $kelas_id)->first();
    
        return view('guru/editpresensi', compact('presensi', 'kelas', 'tanggal'));
    }

    public function UpdatePresensiAction(Request $request) {

        $tanggal = $request->input('tanggal');
        $kelas_id = $request->input('kelas_id');
        
        // Validasi bahwa 'status' adalah array
        $request->validate([
            'status' => 'required|array',
            'tanggal' => 'required|date',
            'kelas_id' => 'required|integer',
        ]);
    
        // Loop melalui semua NISN yang ada di form
        foreach ($request->status as $nisn => $status) {
            // Update status presensi untuk setiap siswa berdasarkan tanggal dan NISN
            DB::table('presensi')
                ->where('tanggal', $request->tanggal)
                ->where('nisn', $nisn)
                ->where('id_kelas', $request->kelas_id) // Pastikan nama kolom sesuai dengan tabel
                ->update(['status' => $status]);
        }
    
        return redirect()->route('EditPresensi', ['tanggal' => $tanggal, 'kelas_id' => $kelas_id])
        ->with('success', 'Data presensi berhasil diubah.');
    }

    public function PilihCetak(){

    // Ambil user yang sedang login
     $user = Auth::user();
    
     // Ambil id_kelas berdasarkan NIP dari user yang login
     $id = DB::table('guru')
         ->join('users', 'users.nip', '=', 'guru.nip')
         ->where('users.id_user', $user->id_user)  // Menggunakan ID user yang login
         ->value('guru.id_kelas');  // Ambil nilai id_kelas

        $siswa = DB::table('siswa')
        ->select('nisn', 'nama')
        ->where('id_kelas', $id)
        ->get();

        return view('guru/pilihcetak', ['siswa' => $siswa]);

    }
    

    public function PilihKelasPelanggaran(){
        
        $kelas = DB::table('kelas')
        ->select('id_kelas','kelas')
        ->get();

        
      return view('guru/pilihkelaspelanggaran', ['kelas' => $kelas]);
    }

    public function TampilSiswaPelanggaran(){

     // Ambil user yang sedang login
     $user = Auth::user();
    
     // Ambil id_kelas berdasarkan NIP dari user yang login
     $id_kelas = DB::table('guru')
         ->join('users', 'users.nip', '=', 'guru.nip')
         ->where('users.id_user', $user->id_user)  // Menggunakan ID user yang login
         ->value('guru.id_kelas');  // Ambil nilai id_kelas
 
     // Ambil data kelas berdasarkan id_kelas
     $kelas = DB::table('kelas')
         ->select('kelas')
         ->where('id_kelas', $id_kelas)
         ->first();
 
     // Ambil data siswa yang terkait dengan id_kelas
     $siswa = DB::table('siswa')
         ->select('nisn', 'nama')
         ->where('id_kelas', $id_kelas)
         ->get();

        return view('guru/tampilsiswapelanggaran', ['siswa' => $siswa, 'kelas' => $kelas]);
    }

    public function LihatPelanggaran($nisn){

        $siswa = DB::table('siswa')
        ->select('nama')
        ->where('nisn', $nisn)
        ->first();

        $pelanggaran = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.waktu', 'jenis_pelanggaran.jenis', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.point', 'pelanggaran.nisn', 'pelanggaran.id_pelanggaran')
        ->where('pelanggaran.nisn', $nisn)
        ->get();

       return view('guru/pelanggaran',['pelanggaran' => $pelanggaran, 'siswa' => $siswa, 'nisn' => $nisn]);
    }

    public function LihatDetailPelanggaran($id){

        $data = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select(
        'jenis_pelanggaran.pelanggaran', 
        'jenis_pelanggaran.jenis', 
        'pelanggaran.catatan', 
        'pelanggaran.point', 
        'pelanggaran.path'
         )
        ->where('pelanggaran.id_pelanggaran', $id)
        ->get();

        return view('guru/detailpelanggaran', ['data' => $data]);

    }

    public function TambahPelanggaran($nisn){

        $siswa = DB::table('siswa')
        ->select('nama')
        ->where('nisn', $nisn)
        ->first();

        $select = DB::table('jenis_pelanggaran')
        ->select('id_jenis', 'jenis', 'pelanggaran', 'point')
        ->get();

        return view('guru/tambahpelanggaran', ['nisn' => $nisn, 'siswa' => $siswa, 'select' => $select]);
    }

    public function TambahPelanggaranAction(Request $request) {
        // Validasi input
        $request->validate([
            'jenis_pelanggaran' => 'required', // Ubah dari 'id_jenis' menjadi 'jenis_pelanggaran'
            'nisn' => 'required',
            'waktu' => 'required|date',
            'catatan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
        ]);
    
        // Ambil nilai point dari jenis pelanggaran yang dipilih
        $jenisPelanggaran = DB::table('jenis_pelanggaran')
            ->select('point')
            ->where('id_jenis', $request->jenis_pelanggaran)
            ->first();
    
        // Pastikan point tidak null
        if (!$jenisPelanggaran) {
            return redirect()->back()->withErrors(['jenis_pelanggaran' => 'Jenis pelanggaran tidak ditemukan.']);
        }
    
        // Proses upload foto jika ada file yang diunggah
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Tentukan nama file dan simpan ke folder public/foto
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName(); // Menambahkan timestamp untuk menghindari nama file duplikat
            $fotoPath = $foto->storeAs('foto', $fotoName, 'public'); // Simpan di folder public/foto
        }
    
        // Memasukkan data ke dalam tabel 'pelanggaran'
        DB::table('pelanggaran')->insert([
            'id_jenis' => $request->jenis_pelanggaran,
            'nisn' => $request->nisn,
            'waktu' => $request->waktu,
            'catatan' => $request->catatan,
            'point' => $jenisPelanggaran->point, // Ambil point dari hasil query di atas
            'path' => $fotoPath, // Simpan path foto jika ada
        ]);
    
        return redirect()->route('LihatPelanggaran', ['nisn' => $request->nisn])
            ->with('success', 'Data pelanggaran berhasil ditambahkan.');
    }
    
    
    public function EditPelanggaran($nisn, $id){

        $siswa = DB::table('siswa')
        ->select('nama', 'nisn')
        ->where('nisn', $nisn)
        ->first();

        $pelanggaran = DB::table('pelanggaran')
        ->join('jenis_pelanggaran', 'pelanggaran.id_jenis', '=', 'jenis_pelanggaran.id_jenis')
        ->select('pelanggaran.nisn', 'pelanggaran.waktu', 'pelanggaran.id_jenis', 'jenis_pelanggaran.pelanggaran', 'pelanggaran.catatan', 'pelanggaran.id_pelanggaran', 'pelanggaran.path')
        ->where('pelanggaran.nisn', $nisn)
        ->where('pelanggaran.id_pelanggaran', $id)
        ->first();
    

        $select = DB::table('jenis_pelanggaran')
        ->select('id_jenis', 'pelanggaran', 'jenis', 'point')
        ->get();
    
    
        return view('guru/editpelanggaran', ['pelanggaran' => $pelanggaran, 'siswa' => $siswa, 'select' => $select]);

    }

    public function HapusPelanggaran($id, $nisn)
{
    // Menghapus data pelanggaran berdasarkan id
    DB::table('pelanggaran')->where('id_pelanggaran', $id)->delete();
    
    // Redirect ke halaman daftar pelanggaran dengan pesan sukses
    return redirect()->route('LihatPelanggaran', ['nisn' => $nisn])
        ->with('success', 'Data pelanggaran berhasil dihapus!');
}

public function UpdatePelanggaranAction(Request $request)
{
    // Validasi input
    $request->validate([
        'jenis_pelanggaran' => 'required', 
        'nisn' => 'required',
        'waktu' => 'required|date',
        'catatan' => 'required|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tambah validasi untuk foto
    ]);

    // Ambil nilai point dari jenis pelanggaran yang dipilih
    $jenisPelanggaran = DB::table('jenis_pelanggaran')
        ->select('point')
        ->where('id_jenis', $request->jenis_pelanggaran)
        ->first();

    // Pastikan point tidak null
    if (!$jenisPelanggaran) {
        return redirect()->back()->withErrors(['jenis_pelanggaran' => 'Jenis pelanggaran tidak ditemukan.']);
    }

    // Logika untuk mengganti foto (jika ada file yang diupload)
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        // Tentukan nama file dan simpan ke folder public/foto
        $foto = $request->file('foto');
        $fotoName = time() . '_' . $foto->getClientOriginalName(); // Menambahkan timestamp untuk menghindari nama file duplikat
        $fotoPath = $foto->storeAs('foto', $fotoName, 'public'); // Simpan di folder public/foto

        // Update data di tabel 'pelanggaran' dengan path foto baru
        DB::table('pelanggaran')
            ->where('id_pelanggaran', $request->id_pelanggaran)
            ->update([
                'id_jenis' => $request->jenis_pelanggaran, // Gunakan id_jenis di sini
                'nisn' => $request->nisn,
                'waktu' => $request->waktu,
                'catatan' => $request->catatan,
                'point' => $jenisPelanggaran->point,
                'path' => $fotoPath, // Simpan path yang benar
            ]);
    } else {
        // Update data di tabel 'pelanggaran' tanpa mengganti foto
        DB::table('pelanggaran')
            ->where('id_pelanggaran', $request->id_pelanggaran)
            ->update([
                'id_jenis' => $request->jenis_pelanggaran, // Gunakan id_jenis di sini
                'nisn' => $request->nisn,
                'waktu' => $request->waktu,
                'catatan' => $request->catatan,
                'point' => $jenisPelanggaran->point,
            ]);
    }

    // Redirect ke route yang relevan dengan pesan sukses
    return redirect()->route('LihatPelanggaran', ['nisn' => $request->nisn])
        ->with('success', 'Data Pelanggaran berhasil diubah!');
}

//menampilkan data presensi siswa sebelum di cetak
public function SeleksiCetak($nisn,Request $request){

    //mengambil data bulan dari view
    $bulan = $request->input('bulan');

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



    return view('guru/presensi',['presensi' => $presensi, 'siswa' => $siswa, 'data' => $data]);
}

    
}
