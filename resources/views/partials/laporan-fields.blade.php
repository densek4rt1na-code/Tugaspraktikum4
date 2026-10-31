@php($l = $laporan ?? null)

<div class="form-group">
    <label for="nama_pelapor">Nama Pelapor</label>
    <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor', $l?->nama_pelapor) }}"
           class="@error('nama_pelapor') is-invalid @enderror" placeholder="Nama lengkap">
    @error('nama_pelapor') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="no_hp">Nomor HP</label>
    <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp', $l?->no_hp) }}"
           class="@error('no_hp') is-invalid @enderror" placeholder="08xxxxxxxxxx">
    @error('no_hp') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="lokasi">Lokasi Kejadian</label>
    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $l?->lokasi) }}"
           class="@error('lokasi') is-invalid @enderror" placeholder="Contoh: Jl. Raya Dayeuhkolot, RT 02/RW 05">
    @error('lokasi') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="kecamatan">Kecamatan</label>
    <select id="kecamatan" name="kecamatan" class="@error('kecamatan') is-invalid @enderror">
        <option value="">-- Pilih kecamatan --</option>
        @foreach ($daftarKecamatan as $kec)
            <option value="{{ $kec }}" @selected(old('kecamatan', $l?->kecamatan) === $kec)>{{ $kec }}</option>
        @endforeach
    </select>
    @error('kecamatan') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="tinggi_air">Tinggi Air (cm)</label>
    <input type="number" id="tinggi_air" name="tinggi_air" min="1" value="{{ old('tinggi_air', $l?->tinggi_air) }}"
           class="@error('tinggi_air') is-invalid @enderror" placeholder="Contoh: 45">
    @error('tinggi_air') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea id="keterangan" name="keterangan" class="@error('keterangan') is-invalid @enderror"
              placeholder="Jelaskan kondisi banjir di lokasi">{{ old('keterangan', $l?->keterangan) }}</textarea>
    @error('keterangan') <div class="error-text">{{ $message }}</div> @enderror
</div>
