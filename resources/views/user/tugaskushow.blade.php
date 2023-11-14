@extends('layout.layout')
@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">


                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Tugas</h5>
                    <small class="text-muted float-end"> <a href="{{ route('tugaskuindex') }}"
                            class="btn btn-sm btn-outline-primary">
                            Back</a></small>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul"
                            value="{{ $tugasku->judul }}" readonly />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tenggat">Tenggat</label>
                        <input type="date" class="form-control" name="tenggat" id="tenggat"
                            value="{{ $tugasku->tenggat }}" readonly />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="basic-default-message">Deskripsi</label>
                        <textarea id="deskripsi" class="form-control" name="deskripsi" readonly>{{ $tugasku->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">File Tugas</label>
                        <div class="input-group input-group-merge">
                            <small class="text-muted float-end"> <a href="{{ asset('storage/' . $tugasku->file) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Download</a></small>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">Status Tugas</label>
                        <div class="input-group input-group-merge">
                            @if ($tugasku->status == 0)
                                <button type="submit" class="btn btn-primary">Active</button>
                            @else
                                <button type="submit" class="btn btn-primary">Complete</button>
                            @endif
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection
