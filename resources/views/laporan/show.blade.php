@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container container-wide">
    <h2>Detail Laporan #{{ $laporan->id }}</h2>

    @include('partials.flash')

    @if ($laporan->foto_url)
        <div style="text-align:center;">
            <img class="foto-detail" src="{{ $laporan->foto_url }}" alt="Foto bukti banjir">
        </div>
    @endif

    <dl class="detail-grid">
        <dt>Nama Pelapor</dt><dd>{{ $laporan->nama_pelapor }}</dd>
        <dt>Nomor HP</dt><dd>{{ $laporan->no_hp }}</dd>
        <dt>Lokasi</dt><dd>{{ $laporan->lokasi }}</dd>
        <dt>Kecamatan</dt><dd>{{ $laporan->kecamatan }}</dd>
        <dt>Tinggi Air</dt><dd>{{ $laporan->tinggi_air }} cm</dd>
        <dt>Keterangan</dt><dd>{{ $laporan->keterangan }}</dd>
        <dt>Status</dt><dd><span class="status-badge {{ $laporan->status_class }}">{{ $laporan->status }}</span></dd>
        <dt>Dilaporkan</dt><dd>{{ $laporan->created_at->translatedFormat('d F Y, H:i') }} WIB</dd>
    </dl>

    <div class="actions">
        <a href="{{ route('laporan.index') }}" class="btn-sm btn-secondary">&laquo; Kembali</a>
        <a href="{{ route('laporan.edit', $laporan) }}" class="btn-sm btn-warn">Edit</a>
        <form action="{{ route('laporan.destroy', $laporan) }}" method="POST"
              onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-sm btn-danger">Hapus</button>
        </form>
    </div>
</div>
@endsection
