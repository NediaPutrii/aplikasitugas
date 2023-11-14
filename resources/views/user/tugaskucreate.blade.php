@extends('layout.layout')
@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">


                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Tugas</h5>
                    <small class="text-muted float-end"> <a href="{{ route('tugaskuindex') }}"
                            class="btn btn-sm btn-outline-primary">
                            Back</a></small>
                </div>
                <form action="{{ route('tugaskustore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                placeholder="Tugas Praktikum Pemograman Mobile.." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tenggat">Tenggat</label>
                            <input type="date" class="form-control" name="tenggat" id="tenggat" placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi Tugas"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Upload Tugas</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" name="file" id="file" />
                            </div>
                            <div class="form-text">ekstensi file : pdf, jpg, jpeg, png, doc</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
