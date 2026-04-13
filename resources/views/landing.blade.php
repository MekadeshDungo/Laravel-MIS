@extends('layouts.main')

@section('title', 'Welcome - Dasmariñas City VetMIS')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        color: white;
        padding: 90px 0;
    }

    .feature-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-6px);
    }

    .announcement-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .announcement-card:hover {
        transform: translateY(-4px);
    }
</style>
@endpush

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <i class="bi bi-hospital-fill display-1 mb-4"></i>

            <h1 class="display-5 fw-bold mb-3">
                City Veterinary Services Office
            </h1>

            <h4 class="fw-semibold mb-3">
                City of Dasmariñas, Cavite
            </h4>

            <p class="lead mb-5" style="max-width: 650px; margin: 0 auto;">
                Veterinary Management Information System for Efficient Public Service,
                Animal Welfare, and Community Health Protection
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Staff Login
                </a>

                <a href="{{ route('announcements.public.index') }}" class="btn btn-outline-light btn-lg px-5">
                    <i class="bi bi-megaphone me-2"></i>Public Announcements
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ================= SERVICES ================= -->
<section class="py-5 bg-light">
    <div class="container">

        <h2 class="text-center fw-bold mb-5 text-success">
            Veterinary Public Services
        </h2>

        <div class="row g-4">

            <!-- Rabies -->
            <div class="col-md-4">
                <div class="feature-card text-center h-100">

                    <i class="bi bi-shield-check display-4 text-success mb-3"></i>

                    <h5 class="fw-bold">Rabies Prevention Program</h5>

                    <p class="text-muted mb-0">
                        Free and subsidized rabies vaccination services
                        to protect residents and their pets.
                    </p>
                </div>
            </div>

            <!-- Bite -->
            <div class="col-md-4">
                <div class="feature-card text-center h-100">

                    <i class="bi bi-exclamation-triangle display-4 text-success mb-3"></i>

                    <h5 class="fw-bold">Animal Bite Monitoring</h5>

                    <p class="text-muted mb-0">
                        Centralized reporting and monitoring of animal bite
                        incidents within barangays.
                    </p>
                </div>
            </div>

            <!-- Meat -->
            <div class="col-md-4">
                <div class="feature-card text-center h-100">

                    <i class="bi bi-clipboard-check display-4 text-success mb-3"></i>

                    <h5 class="fw-bold">Meat Inspection Services</h5>

                    <p class="text-muted mb-0">
                        Inspection and certification of meat products
                        for food safety compliance.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= ANNOUNCEMENTS ================= -->
<section class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold text-success mb-0">
                <i class="bi bi-megaphone-fill me-2"></i>
                Latest Public Announcements
            </h2>

            <a href="{{ route('announcements.public.index') }}"
               class="btn btn-outline-success">

                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>

        </div>

        @php
            $recentAnnouncements = \App\Models\Announcement::where('is_active', true)
                ->latest()
                ->take(3)
                ->get();
        @endphp


        @if($recentAnnouncements->count() > 0)

            <div class="row g-4">

                @foreach($recentAnnouncements as $announcement)

                    <div class="col-md-4">

                        <div class="announcement-card h-100">

                            @if($announcement->photo_path)

                                <img src="{{ asset('storage/' . $announcement->photo_path) }}"
                                     class="card-img-top"
                                     alt="{{ $announcement->title }}"
                                     style="height: 160px; object-fit: cover;">

                            @else

                                <div class="bg-success bg-opacity-10
                                            d-flex align-items-center justify-content-center"
                                     style="height: 160px;">

                                    <i class="bi bi-megaphone text-success fs-1"></i>

                                </div>

                            @endif


                            <div class="card-body">

                                <h6 class="card-title fw-bold text-success">
                                    {{ $announcement->title }}
                                </h6>

                                <p class="card-text small text-muted">
                                    {{ Str::limit($announcement->description, 110) }}
                                </p>


                                @if($announcement->event_date)

                                    <small class="text-success">

                                        <i class="bi bi-calendar-event me-1"></i>

                                        {{ \Carbon\Carbon::parse($announcement->event_date)->format('F d, Y') }}

                                    </small>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-5 bg-light rounded">

                <i class="bi bi-megaphone text-muted fs-1"></i>

                <h5 class="mt-3 text-muted">
                    No Announcements Available
                </h5>

                <p class="text-muted">
                    Please check again later for official updates.
                </p>

            </div>

        @endif

    </div>
</section>


<!-- ================= CONTACT ================= -->
<section class="py-5 bg-light">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h2 class="fw-bold text-success mb-4">
                    Contact Information
                </h2>


                <div class="mb-3">
                    <i class="bi bi-geo-alt-fill text-success me-2"></i>
                    <span>
                        City Veterinary Office, Dasmariñas City, Cavite
                    </span>
                </div>


                <div class="mb-3">
                    <i class="bi bi-telephone-fill text-success me-2"></i>
                    <span>
                        (046) 481-8000 local 2345
                    </span>
                </div>


                <div class="mb-3">
                    <i class="bi bi-envelope-fill text-success me-2"></i>
                    <span>
                        cityvet@dasmarinas.gov.ph
                    </span>
                </div>


                <div class="mb-3">
                    <i class="bi bi-clock-fill text-success me-2"></i>
                    <span>
                        Monday – Friday | 8:00 AM – 5:00 PM
                    </span>
                </div>

            </div>


            <div class="col-md-6 text-md-end">

                <i class="bi bi-headset text-success" style="font-size: 7.5rem;"></i>

            </div>

        </div>

    </div>

</section>

@endsection
