@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- 3 article terbaru -->
                <div class="row" id="view">
                    @forelse ($artikel as $a)
                        <div class="col-md-4">
                            <div class="card mt-3">
                                <img class="card-img-top" src="{{ asset('storage/' . $a->image) }}">
                                <div class="card-body">
                                    <form id="form-like">
                                        <input id="id-article-{{ $a->id }}" type="hidden"
                                            value="{{ $a->id }}">
                                        <a class="nav-link" id="like-{{ $a->id }}" href="">
                                            <i class="bi bi-heart"></i> Like
                                        </a>
                                    </form>
                                    @php
                                        $description = substr($a->description, 0, 100);
                                    @endphp
                                    <p class="card-text mt-3" id="description-artikel-{{ $a->id }}">
                                        {{ $description }} .....
                                        <a data-bs-toggle="modal" data-bs-target="#read-more-{{ $a->id }}"
                                            href="">Read More
                                        </a>
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
                <!-- end 3 article terbaru -->

                <!-- view all article -->
                <div class="row" id="viewAll">
                    <!--tampilkan semua article ketika view all ditekan -->
                </div>
                <!-- end view all article -->

                <!-- button view all -->
                <div id="btnViewAll">
                    <a class="nav-link mt-3 text-center" id="view-all" href="">View All
                        <i class="bi bi-chevron-compact-down"></i>
                    </a>
                </div>
                <!-- end button view all -->
            </div>
        </div>
    </div>
    <!-- Modal -->
    @foreach ($viewAll as $a)
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
                                <!-- form like -->
                                <form id="form-like">
                                    <input id="id-article-{{ $a->id }}" type="hidden" value="{{ $a->id }}">
                                    <a class="nav-link" id="like-{{ $a->id }}" type="submit" href=""><i
                                            class="bi bi-heart"></i>
                                        Like</a>
                                </form>
                                <!-- end form like -->
                                <p class="card-text mt-3" id="">{{ $a->description }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal" type="button">Close</button>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
    <!-- End Modal -->
@endsection
@section('script')
    <!-- jquery view all article -->
    <script>
        $(document).ready(function() {
            //view all
            $('#view-all').on('click', function(e) {
                e.preventDefault()
                $.ajax({
                    url: "{{ route('all') }}",
                    type: "GET",
                    success: function(response) {
                        $("#view").html("")
                        $("#viewAll").html(response)
                        $("#btnViewAll").html("")
                    },
                    error: function() {
                        console.log('Error')
                    }
                })
            })
        })
    </script>
    <!-- end jquery view all article -->
    <!-- jquery like article -->
    @foreach ($viewAll as $view)
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#like-{{ $view->id }}").on('click', function(e) {
                    e.preventDefault()
                    let idUserLiked = "{{ Auth::user()->id }}"
                    let idPost = $("#id-article-{{ $view->id }}").val()
                    $.ajax({
                        url: "{{ route('like') }}",
                        type: "POST",
                        data: {
                            idUserLiked: idUserLiked,
                            idPost: idPost
                        },
                        success: function(response) {
                            console.log(response.idArticle)
                        },
                        error: function() {
                            console.log('Error')
                        }
                    })
                })
            })
        </script>
    @endforeach
    <!-- end jquery like article -->
@endsection
