@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran - Admin')

@section('content')
    <div class="position-relative">
        <h1 class="welcome-header">Tambah Tahun Ajaran</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.academic-years.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="year_start" class="form-label">Tahun Ajaran</label>
                            <div class="input-group">
                                <input type="text" class="form-control year-picker @error('year_start') is-invalid @enderror" id="year_start" name="year_start" value="{{ old('year_start') }}" placeholder="Tahun Mulai" readonly>
                                <span class="input-group-text">/</span>
                                <input type="text" class="form-control year-picker @error('year_end') is-invalid @enderror" id="year_end" name="year_end" value="{{ old('year_end') }}" placeholder="Tahun Selesai" readonly>
                                <input type="hidden" id="year" name="year" value="{{ old('year') }}">
                            </div>
                            @error('year')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Klik pada input untuk memilih tahun</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan Tahun Ajaran Ini</label>
                            <div class="form-text">Jika diaktifkan, tahun ajaran lain akan dinonaktifkan secara otomatis.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.academic-years.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi year picker
        $('.year-picker').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose: true
        });
        
        // Update hidden input saat tahun berubah
        $('#year_start, #year_end').on('changeDate', function() {
            updateYearField();
        });
        
        function updateYearField() {
            var yearStart = $('#year_start').val();
            var yearEnd = $('#year_end').val();
            
            if (yearStart && yearEnd) {
                $('#year').val(yearStart + '/' + yearEnd);
            }
        }
        
        // Jika ada nilai awal, pisahkan dan isi ke masing-masing field
        var initialYear = "{{ old('year') }}";
        if (initialYear) {
            var years = initialYear.split('/');
            if (years.length === 2) {
                $('#year_start').val(years[0]);
                $('#year_end').val(years[1]);
            }
        }
    });
</script>
@endsection