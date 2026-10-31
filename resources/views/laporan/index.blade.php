@extends('layouts.app')

@section('title', 'Kelola Laporan')

@section('content')
<div class="container container-wide">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <h2 style="margin: 0;">Daftar Laporan Banjir</h2>
        <a href="{{ route('lapor.create') }}" class="btn-sm btn-info" style="padding: 10px 18px; font-size: 0.9rem;">+ Tambah Laporan</a>
    </div>

    @include('partials.flash')

    <div class="table-wrap">
        <table class="data">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Pelapor</th>
                    <th>Lokasi</th>
                    <th>Tinggi Air</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $laporan)
                    <tr>
                        <td>{{ $laporans->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($laporan->foto_url)
                                <img class="thumb" src="{{ $laporan->foto_url }}" alt="Foto banjir {{ $laporan->lokasi }}">
                            @else
                                <div class="thumb-empty">Tanpa foto</div>
                            @endif
                        </td>
                        <td>{{ $laporan->nama_pelapor }}<br><small>{{ $laporan->no_hp }}</small></td>
                        <td>{{ $laporan->lokasi }}<br><small>Kec. {{ $laporan->kecamatan }}</small></td>
                        <td>{{ $laporan->tinggi_air }} cm</td>
                        <td><span class="status-badge {{ $laporan->status_class }}">{{ $laporan->status }}</span></td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('laporan.show', $laporan) }}" class="btn-sm btn-info">Detail</a>
                                <a href="{{ route('laporan.edit', $laporan) }}" class="btn-sm btn-warn">Edit</a>
                                <form action="{{ route('laporan.destroy', $laporan) }}" method="POST"
                                      onsubmit="return confirm('Hapus laporan ini beserta fotonya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; padding: 30px; color:#777;">Belum ada laporan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $laporans->links() }}
</div>
@endsection
