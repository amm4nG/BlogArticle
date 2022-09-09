@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <!-- card artikel -->
                <div class="row" id="row">
                    @forelse ($articles as $a)
                        <div class="col-md-4">
                            <div class="card mt-3">
                                <img class="card-img-top" id="artikel-image" src="{{ asset('storage/' . $a->image) }}">
                                <div class="card-body">
                                    <a class="nav-link" href="{{ url('login') }}"><i class="bi bi-heart"></i> Like</a>
                                    @php
                                        $description = substr($a->description, 0, 100);
                                    @endphp
                                    <p class="card-text mt-3" id="description-artikel-{{ $a->id }}">
                                        {{ $description }} .....
                                        <a href="{{ url('login') }}">Read More</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="position-relative mt-5" id="no-article">
                            <h5 class="position-absolute top-50 start-50 translate-middle"><i class="bi bi-bug"></i> Tidak
                                Ada Artikel</h5>
                        </div>
                    @endforelse
                </div>
                <!-- end card artikel -->
            </div>
        </div>
    @endsection
