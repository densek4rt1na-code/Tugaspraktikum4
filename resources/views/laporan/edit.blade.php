@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2>Edit Laporan #{{ $laporan->id }}</h2>

    @include('partials.flash')

    <form action="{{ route('laporan.update', $laporan) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        @include('partials.laporan-fields', ['daftarKecamatan' => $daftarKecamatan, 'laporan' => $laporan])

        <div class="form-group">
            <label for="status">Status Penanganan</label>
            <select id="status" name="status" class="@error('status') is-invalid @enderror">
                @foreach (\App\Models\Laporan::DAFTAR_STATUS as $st)
                    <option value="{{ $st }}" @selected(old('status', $laporan->status) === $st)>{{ $st }}</option>
                @endforeach
            </select>
            @error('status') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="foto">Ganti Foto Bukti (opsional)</label>
            @if ($laporan->foto_url)
                <img class="thumb" style="width:140px;height:100px;margin-bottom:8px;" src="{{ $laporan->foto_url }}" alt="Foto saat ini">
            @endif
            <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                   class="@error('foto') is-invalid @enderror">
            <div class="hint">Kosongkan jika tidak ingin mengganti foto. JPG/JPEG/PNG, maks. 2 MB.</div>
            @error('foto') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-inline">Simpan Perubahan</button>
            <a href="{{ route('laporan.show', $laporan) }}" class="btn-sm btn-secondary" style="padding:12px 20px;">Batal</a>
        </div>
    </form>
</div>
@endsection
