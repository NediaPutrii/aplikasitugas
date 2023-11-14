<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TugaskuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tugaskuactive = 'active';
        $email = Auth::user()->email;
        // $tugasku =DB::table('tugas')->all();
        $tugasku = DB::select("SELECT * FROM tugas where email='$email'");
       
        $role = Auth::user()->role;
        if($role=='0'){
        return view('user.tugaskuindex', 
            [
                'tugaskuactive' => $tugaskuactive,
                'tugasku' => $tugasku
            ]);
        }else{
            return view('error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->role;
        if($role=='0'){
            return view('user.tugaskucreate');
        }else{
            return view('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->file;
        function generateRandomString($length = 5)
        {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
                return $randomString;
        }

        $author = Auth::user()->email;

        $validatedData = $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf,docx|max:2048', // Sesuaikan dengan jenis file yang diizinkan dan ukuran maksimum.
    ]);
        
        if($request->file('file')){
            $file = $request->file('file')->store('public/uploads');
        }

        // return $file;

        $tugasku = new Tugas;
        // $tugasku->id = generateRandomString();
        $tugasku->judul = $request->judul;
        $tugasku->deskripsi = $request->deskripsi;
        $tugasku->tenggat = $request->tenggat;
        $tugasku->created_at = date('Y-m-d H:i:s');
        $tugasku->email = $author;
        $tugasku->file = $file;
        $tugasku ->save();
        
        if($tugasku){
            return redirect()->route('tugaskuindex')
            ->with('success', 'Berhasil Tambah Tugas');
            // ->with('error', 'Gagal Daftar KKN');
        }else{
            return redirect()->route('tugaskuindex')
            ->with('error', 'Gagal Tambah Tugas');
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
        $email = Auth::user()->email;
        $tugasku = Tugas::where('id' , $id)->first();
        $tugaskuactive = 'active';
        return view('user.tugaskushow', 
        [
            'tugasku' => $tugasku,
            'tugaskuactive' => $tugaskuactive
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tugasku = Tugas::where('id' , $id)->first();
        $tugaskuactive = 'active';
        return view('user.tugaskuedit', 
        [
            'tugasku' => $tugasku,
            'tugaskuactive' => $tugaskuactive
        ]);
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
        
        $post = Tugas::where('id',$id)
        ->first();

        if (empty($request->file('file'))){
        $post->where('id',$id)
        ->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tenggat' => $request->tenggat,
            'status' => $request->status,
            'file' => $post->file
        ]) ;
        }else{
            Storage::disk('public')->delete($post->file);
            $file = $request->file('file')->store('uploads');
            $post->where('id',$id)
            ->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tenggat' => $request->tenggat,
                'status' => $request->status,
                'file' => $file
            ]) ;
            
        }
      

        if ($post) {
            return redirect()
                ->route('tugaskuindex')
                ->with([
                    'success' => 'Berita has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Tugas::where('id',$id)
        ->delete();

        if ($post) {
            return redirect()
                ->route('tugaskuindex')
                ->with([
                    'success' => 'Tugas has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('tugaskuindex')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
