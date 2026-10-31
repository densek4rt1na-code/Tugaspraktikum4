@if (session('success'))
    <div class="alert alert-success" role="status">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        Terdapat {{ $errors->count() }} kesalahan pada isian. Silakan periksa kembali form di bawah.
    </div>
@endif
