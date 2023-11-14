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
                <form action="{{ route('tugaskuupdate', $tugasku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="{{ $tugasku->judul }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tenggat">Tenggat</label>
                            <input type="date" class="form-control" name="tenggat" id="tenggat"
                                value="{{ $tugasku->tenggat }}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi">{{ $tugasku->deskripsi }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Status</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="status"
                                aria-label="Default select example">
                                @if (isset($tugasku->status))
                                    @if ($tugasku->status == 0)
                                        <option value="{{ $tugasku->status }}" selected>Active</option>
                                    @else
                                        <option value="{{ $tugasku->status }}" selected>Complete</option>
                                    @endif
                                @endif
                                <option value="0">Active</option>
                                <option value="1">Complete</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">File Tugas</label>
                            @if (isset($tugasku->file))
                                <div>
                                    <span>Uploaded :</span>
                                    <small class="text-muted"> <a href="{{ asset('/' . $tugasku->file) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Download</a></small>
                                </div>
                            @endif
                            <br>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="file" name="file" id="file"
                                    value="{{ $tugasku->file }}" />
                            </div>
                            <div class="form-text">ekstensi file : pdf, jpg, jpeg, png, doc</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
