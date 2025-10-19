@extends('layouts.app')

@section('title', $facility->name . ' - Fasilitas')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    @if($facility->image)
                        <img src="{{ Storage::url($facility->image) }}" class="card-img-top" style="max-height: 420px; object-fit: cover;" alt="{{ $facility->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 320px;">
                            <i class="bi bi-building text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge bg-primary">{{ $facility->category }}</span>
                            @if($facility->capacity)
                                <span class="badge bg-info"><i class="bi bi-people me-1"></i>{{ $facility->capacity }}</span>
                            @endif
                            @if($facility->status)
                                <span class="badge bg-success">{{ ucfirst($facility->status) }}</span>
                            @endif
                        </div>
                        <h2 class="h3 mb-3">{{ $facility->name }}</h2>
                        @if($facility->location)
                            <p class="text-muted mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $facility->location }}</p>
                        @endif
                        <p class="mb-0">{!! nl2br(e($facility->description)) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Fitur</h5>
                        @if($facility->features && count($facility->features) > 0)
                            <div>
                                @foreach($facility->features as $feature)
                                    <span class="badge bg-light text-dark border me-1 mb-1">{{ $feature }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Tidak ada fitur khusus.</p>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Fasilitas Terkait</h5>
                        @if($relatedFacilities->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($relatedFacilities as $item)
                                    <a href="{{ route('fasilitas.show', $item) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <div class="me-3" style="width: 56px; height: 56px; overflow: hidden; border-radius: 8px;">
                                            @if($item->image)
                                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width: 56px; height: 56px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                                    <i class="bi bi-building text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $item->name }}</div>
                                            <small class="text-muted">{{ $item->category }}</small>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Tidak ada fasilitas terkait.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('fasilitas') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali ke daftar</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
