@extends('layouts.app')

@section('title', $organization->name . ' - Organisasi')

@section('content')
<section class="page-header">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-2">
          @if($organization->image)
            <img src="{{ $organization->image }}" alt="{{ $organization->name }}" style="height:64px;width:64px;object-fit:contain" class="me-2 align-text-top">
          @else
            <i class="bi {{ $organization->icon }} me-2"></i>
          @endif
          {{ $organization->name }}
        </h1>
        @if($organization->tagline)
          <p class="lead mb-0">"{{ $organization->tagline }}"</p>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('organisasi') }}">Organisasi</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $organization->name }}</li>
      </ol>
    </nav>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Tentang Organisasi</h5>
            <p class="mb-0">{{ $organization->description }}</p>
          </div>
        </div>

        @if($organization->programs && is_array($organization->programs) && count($organization->programs) > 0)
        <div class="card border-0 shadow-sm mt-3">
          <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-target me-2"></i>Program Kerja</h5>
            <ul class="mb-0">
              @foreach($organization->programs as $program)
                <li>{{ $program }}</li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif

        @if($organization->leadership && is_array($organization->leadership) && count($organization->leadership) > 0)
        <div class="card border-0 shadow-sm mt-3">
          <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-people me-2"></i>Struktur Kepengurusan</h5>
            <div class="row g-3">
              @foreach($organization->leadership as $leader)
              <div class="col-md-6">
                <div class="p-3 bg-light rounded h-100">
                  <div class="fw-semibold">{{ $leader['name'] ?? '-' }}</div>
                  <div class="text-muted">{{ $leader['position'] ?? '' }}</div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm mt-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Anggota (Siswa)</h5>
              <span class="badge bg-primary">{{ $organization->students->count() }} siswa</span>
            </div>
            @if($organization->students->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 g-2">
              @foreach($organization->students as $student)
              <div class="col">
                <div class="p-2 border rounded d-flex align-items-center gap-2">
                  <i class="bi bi-person-circle fs-4 text-secondary"></i>
                  <div>
                    <div class="fw-semibold">{{ $student->name }}</div>
                    <small class="text-muted">Kelas {{ $student->class ?? '-' }}</small>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @else
              <p class="text-muted mb-0">Belum ada anggota terdaftar.</p>
            @endif
          </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Pembina (Guru)</h5>
              <span class="badge bg-success">{{ $organization->teachers->count() }} pembina</span>
            </div>
            @if($organization->teachers->count() > 0)
            <div class="list-group list-group-flush">
              @foreach($organization->teachers as $teacher)
              <div class="list-group-item d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-person-badge fs-5 text-secondary"></i>
                  <div>
                    <div class="fw-semibold">{{ $teacher->name }}</div>
                    <small class="text-muted">{{ $teacher->subject ?? 'Guru' }} • {{ $teacher->pivot->role ?? 'pembina' }}</small>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @else
              <p class="text-muted mb-0">Belum ada pembina ditetapkan.</p>
            @endif
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-ui-checks-grid me-2"></i>Informasi</h5>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><span class="badge bg-{{ $organization->color ?? 'primary' }}">{{ $organization->type }}</span></li>
              @if($organization->email)
              <li class="mb-1"><i class="bi bi-envelope me-2"></i>{{ $organization->email }}</li>
              @endif
              @if($organization->phone)
              <li class="mb-1"><i class="bi bi-phone me-2"></i>{{ $organization->phone }}</li>
              @endif
              @if($organization->location)
              <li class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ $organization->location }}</li>
              @endif
              @if(!empty($organization->contact_person))
              <li class="mb-1"><i class="bi bi-person-lines-fill me-2"></i>{{ $organization->contact_person }}</li>
              @endif
              @if(!empty($organization->website))
              <li class="mb-1"><i class="bi bi-globe me-2"></i><a href="{{ $organization->website }}" target="_blank" rel="noopener">{{ $organization->website }}</a></li>
              @endif
            </ul>

            @if($organization->tags && is_array($organization->tags) && count($organization->tags) > 0)
            <div class="mb-3">
              @foreach($organization->tags as $tag)
                <span class="badge bg-light text-dark border me-1 mb-1">{{ $tag }}</span>
              @endforeach
            </div>
            @endif

            <div class="d-grid">
              <a class="btn btn-{{ $organization->color ?? 'primary' }}" href="{{ route('registration.show', $organization) }}">
                <i class="bi bi-person-plus me-2"></i>Bergabung
              </a>
              <a class="btn btn-outline-secondary mt-2" href="{{ route('organisasi') }}">
                <i class="bi bi-arrow-left me-2"></i>Kembali
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
