@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2>Laporkan Kejadian Banjir</h2>

    @include('partials.flash')

    <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        @include('partials.laporan-fields', ['daftarKecamatan' => $daftarKecamatan])

        <div class="form-group">
            <label for="foto">Foto Bukti Banjir</label>
            <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                   class="@error('foto') is-invalid @enderror">
            <div class="hint">Format JPG, JPEG, atau PNG. Ukuran maksimal 2 MB.</div>
            @error('foto') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn">Kirim Laporan</button>
    </form>
</div>
@endsection
