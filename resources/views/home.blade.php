@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    @forelse ($artikel as $a)
                        <div class="col-md-4">
                            <div class="card mt-3">
                                <img class="card-img-top" src="{{ asset('storage/' . $a->image) }}" alt="...">
                                <div class="card-body">
                                    <a class="nav-link" href=""><i class="bi bi-heart"></i> Like</a>
                                    <p class="card-text mt-3" id="description-artikel">{{ $a->description }}</p>
                                    <a class="nav-link text-primary" href="">
                                        Detail <i class="bi text-primary bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="position-relative mt-5">
                            <h5 class="position-absolute top-50 start-50 translate-middle"><i class="bi bi-bug"></i> Tidak
                                Ada Artikel</h5>
                        </div>
                    @endforelse
                </div>
                <!-- end card artikel -->
            </div>
        </div>
    </div>
@endsection
