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
                                    @php
                                        $description = substr($a->description, 0, 100);
                                    @endphp
                                    <p class="card-text mt-3" id="description-artikel-{{ $a->id }}">
                                        {{ $description }} .....
                                        <a data-bs-toggle="modal" data-bs-target="#read-more-{{ $a->id }}"
                                            href="">Read More</a>
                                    </p>
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

    <!-- Modal -->
    @foreach ($artikel as $a)
        <div class="modal fade" id="read-more-{{ $a->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">LITA' MANDAR</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mt-3">
                            <img class="card-img-top" src="{{ asset('storage/' . $a->image) }}">
                            <div class="card-body">
                                <a class="nav-link" href=""><i class="bi bi-heart"></i> Like</a>
                                <p class="card-text mt-3" id="">{{ $a->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Modal -->
@endsection
{{-- @section('script')
    @foreach ($artikel as $article)
        <script>
            //read more
            function readMore() {
                $("#read-more-{{ $article->id }}").on('click', function(e) {
                    e.preventDefault()
                    let id = $("#more-article-{{ $article->id }}").val()
                    $.ajax({
                        url: "{{ route('more') }}",
                        type: "GET",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $("#description-artikel-{{ $article->id }}").html(response.description)
                        },
                        error: function() {
                            console.log('Terjadi Kesalahan')
                        }
                    })
                })
            }
            //end function read more

            //runing funtion
            readMore()
            //end running function
        </script>
    @endforeach
@endsection --}}
