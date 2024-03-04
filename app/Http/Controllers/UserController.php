<?php

namespace App\Http\Controllers;

use App\Models\foto;
use App\Models\User;
use App\Models\album;
use App\Models\folowers;
use App\Models\likefoto;
use App\Models\komenfoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //proses register
    public function register(Request $request)
    {
        $messages = [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
        ];
        
        // Validasi
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'email' => 'required|unique:users,email',
        ], $messages);
        
        // Simpan
        $dataStore = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ];
        
        User::create($dataStore);
        return redirect('/register')->with('success', 'Data berhasil disimpan');        

    }
    //log in
    public function ceklogin (Request $request){
        // Validate
        $request->validate([
            'email' => ['required', 'email'],
            'password'  => ['required'],
        ]);

        // Proses log in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/explore');
        } else {
            throw ValidationException::withMessages([
                'email' => 'Email atau Password Anda Salah',  
            ]);
        }

    }
    //logout
    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
    //upload foto
    public function upload_foto(Request $request)
    {
        $namafile   = pathinfo($request->file, PATHINFO_FILENAME);
        $extensi    = $request->file->getClientOriginalExtension();
        $namafoto   = 'postingan' . time() . '.' . $extensi;
        $request->file->move('postingan', $namafoto);
        //simpan
        $datasimpan = [
            'users_id' => auth()->User()->id,
            'judul_foto' => $request->judul_foto,
            'deksripsi_foto' => $request->deksripsi_foto,
            'lokasi_file'   => $namafoto,
            'album_id' => $request->album,
           
        ];
        foto::create($datasimpan);
        return redirect('/explore');
    }
    //getDataExplore
    public function getdata(Request $request){
        $explore = foto::with(['likefoto','album','users'])->withCount(['likefoto','komenfoto'])->paginate(4);
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser'    => auth()->user()->id
        ]);
    }
    //likefoto
    public function likesfoto(Request $request)
    {
        try {
            $request->validate([
                'idfoto' => 'required'
            ]);
            $existingLike = likefoto::where('foto_id', $request->idfoto)->where('users_id', auth()->user()->id)->first();
            if(!$existingLike){
                $dataSimpan = [
                    'foto_id'   => $request->idfoto,
                    'users_id'   => auth()->user()->id
                ];
                likefoto::create($dataSimpan);
            } else {
                likefoto::where('foto_id', $request->idfoto)->where('users_id', auth()->user()->id)->delete();
            }

            return response()->json('Data berhasil di simpan ', 200);
        } catch (\Throwable $th) {
            return response()->json('Something want wrong', 500,);
        }
    }
    //explore
    public function explore()
    {
        return view('user.explore');
    }
    //tambah album
    public function tambahalbum(Request $request)
    {
        //simpan
        $tambahalbum = [
            'users_id' => auth()->User()->id,
            'Nama_Album' => $request->Nama_Album,
            'deskripsi' => $request->deskripsi,
        ];
        album::create($tambahalbum);
        return redirect('/upload');
    }
    //getDataPostingansemua
    public function getdatapostingan(Request $request){
        $postinganuserid = auth()->user()->id;
        $explore = foto::with(['likefoto','album','users'])->withCount(['likefoto','komenfoto'])->whereHas('users', function($query) use($postinganuserid){ $query->where('users_id', $postinganuserid);})->paginate(4);
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser'    => auth()->user()->id
        ]);
    }
    //getDataAlbum
    public function getdataalbum(Request $request){
        $postinganuserid = auth()->user()->id;
        $explore = foto::with(['likefoto','album','users'])->withCount(['likefoto','komenfoto'])->whereHas('users', function($query) use($postinganuserid){ $query->where('users_id', $postinganuserid);})->where('album_id','!=',null)->paginate();
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser'    => auth()->user()->id
        ]);
    }
    
    // album
    public function album()
    {
        $data_album = album::all();
        return view('user.album',compact('data_album'));
    }
    //profil
    public function profil()
    {
        $data = [
            'dataprofile'   => User::where('id', auth()->user()->id)->first()
        ];
        return view('user.profil', $data);
    }
    //updatedataprofile
    public function updatedataprofile(Request $request)
    {
        $dataupdate = [
            'username' =>$request->username,
            'nama_lengkap' =>$request->nama_lengkap,
            'jenis_kelamin' =>$request->jenis_kelamin,
            'no_telephone'  =>$request->no_telephone,
            'alamat'    =>$request->alamat,
            'bio'   =>$request->bio,
        ];
        ////proses update
        User::where('id', auth()->user()->id)->update($dataupdate);
        return redirect('/profile');
    }
    //fotoprofil
    public function fotoprofil(Request $request)
    {
        $namafile   = pathinfo($request->file, PATHINFO_FILENAME);
        $extensi    = $request->file->getClientOriginalExtension();
        $namafoto   = 'profile' . time() . '.' . $extensi;
        $request->file->move('pic', $namafoto);
        //data
        $dataupdate = [
            'foto_profil'  =>$namafoto,
        ];
        //proses update
        User::where('id', auth()->user()->id)->update($dataupdate);
        return redirect('/profile');
    }
    //upload
    public function upload()
    {
        $data_album = album::all();
        return view('user.upload',compact('data_album'));

    }
    //about
    public function about()
    {
        return view('user.about');

    }
    //explore detail
    public function explore_detail($id)
    {
        return view('user.explore-detail',[
            'foto' => foto::whereId($id)->first(),
            // 'foto' => foto::whereId($id)->first()
        ]);
    }
    //Exploredatadetail
    public function getdatadetail(Request $request, $id){
        $dataDetailFoto     = foto::with(['users','album'])->where('id', $id)->firstOrFail();
        $dataJumlahPengikut = DB::table('folowers')->selectRaw('count(id_following) as jmlfolow')->where('id_following', $dataDetailFoto->users->id)->first();
        $dataFollow         = folowers::where('id_following', $dataDetailFoto->users->id)->where('users_id', auth()->user()->id)->first();
        return response()->json([
            'dataDetailFoto'    => $dataDetailFoto,
            'dataJumlahFollow'  => $dataJumlahPengikut,
            'dataUser'          => auth()->user()->id,
            'dataFollow'        => $dataFollow,
        ], 200);
    }
    //datakomentar
    public function ambildatakomentar(Request $request, $id){
        $ambilkomentar = komenfoto::with('users')->where('foto_id', $id)->get();
        return response()->json([
            'data'  => $ambilkomentar,
        ], 200);
    }
    //kirimkomentar
    public function kirimkomentar(Request $request){
        try {
            $request->validate([
                'idfoto'   => 'required',
                'isi_komentar'  => 'required',
            ]);
            $dataStoreKomentar = [
                'users_id'  => auth()->user()->id,
                'foto_id'   => $request->idfoto,
                'isi_komentar'  => $request->isi_komentar,
            ];
            komenfoto::create($dataStoreKomentar);
            return response()->json([
                'data'      => 'Data berhasil di simpan',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json('Data komentar  gagal di simpann', 500);
        }
    }
    //explore edit password
    public function edit_password_username()
    {
        return view('user.changepassword');
    }
    // ChangePasswordController.php
    public function update(Request $request)
    {
       $request->validate([
           'current_password' => 'required',
           'password' => 'required|min:8',
       ]);

       $user = Auth::user();
    //dd($request->current_password);
       if (!Hash::check($request->current_password, $user->password)) {
           return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => bcrypt($request->password),
         ]);

       return redirect()->back()->with('success', 'Password berhasil diubah ');
    }
    //explore profil public
    public function profil_public($id)
    {
        $user = User::find($id);
        return view('user.profil-public',[
            'username' => $user->username,
            'foto_profil' => $user->foto_profil,
            'bio'   => $user->bio,
            'user_id'   => $id,
            'folowers_id' => folowers::where('id_following',$id)->pluck('users_id')->toArray(),            
        ]);
    }
    //getDataPublic
    public function getdatapublic(Request $request,$id){
        $publicuserid = auth()->user()->id;
        $explore = foto::with(['likefoto','album','users'])->withCount(['likefoto','komenfoto'])->where('users_id', $id)->paginate(4);
        return response()->json([
            'data' => $explore,
            'statuscode' => 200,
            'idUser'    => auth()->user()->id
        ]);
    }
    //delete
    public function deletefoto(Request $request, $id){
        foto::where('id',$id)->delete();
        return response()->json(['success' => 'berhasil']);
    }
}
