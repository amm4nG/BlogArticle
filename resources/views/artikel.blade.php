@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <!-- validation error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- end validation error -->

                <!-- alert new article -->
                @if (session('new_article'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('new_article') }}
                        <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
                    </div>
                @endif
                <!-- end alert new article -->

                <!-- button upload artikel -->
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-6">
                        <a class="btn btn-outline-info rounded-pill form-control" data-bs-toggle="modal"
                            data-bs-target="#artikel-baru" href="">New Article</a>
                    </div>
                </div>
                <!-- end button upload artikel -->

                <!-- modal upload artikel-->
                <div class="modal fade" id="artikel-baru" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Artikel Baru</h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <ul id="errorList"></ul>

                                {{-- form upload postingan --}}
                                <form id="artikel-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating">
                                        <textarea class="form-control mb-2" id="description" name="description" style="height: 100px"
                                            placeholder="Leave a comment here"></textarea>
                                        <label for="floatingTextarea2">Description Article?</label>
                                    </div>
                                    <input class="form-control mb-3 mt-3" id="image" name="image" type="file">
                                    <center>
                                        <img class="img-fluid" id="preview-image" name="image-preview"
                                            src="{{ asset('storage/uploads/no-photo.png') }}"
                                            alt="Tidak Ada Gambar Yang Dipilih">
                                    </center>
                                    <div class="modal-footer mt-3">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"
                                            type="button">Cancel</button>
                                        <button class="btn btn-primary" id="upload" type="submit">Upload</button>
                                    </div>
                                </form>
                                {{-- end form upload postingan --}}

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal upload artikel -->

                <!-- card artikel -->
                <div class="row" id="row">
                    @forelse ($artikel as $a)
                        <div class="col-md-4">
                            <div class="card mt-3">
                                <img class="card-img-top" id="artikel-image" src="{{ asset('storage/' . $a->image) }}">
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
                        <div class="position-relative mt-5" id="no-article">
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
@section('script')
    <script>
        //autofokus pada inputan dalam modal
        $('#artikel-baru').on('shown.bs.modal', function() {
            $("#description").focus();
        })

        //menampilkan image yang dipilih
        $('#image').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(document).on('submit', '#artikel-form', function(e) {
                e.preventDefault()
                let descriptionArtikel = $("#description").val()
                let imageArtikel = $("#image").val()
                let formData = new FormData($('#artikel-form')[0])
                let asset = "{{ asset('storage/') }}/"
                $.ajax({
                    url: "{{ route('artikel.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 422) {
                            // action error
                            console.log(response.status);
                            $.each(response.errors, function(key, err_values) {
                                $('#errorList').addClass('alert alert-danger')
                                $('#errorList').append("<li class='ms-2'>" +
                                    err_values +
                                    "</li>")
                            })
                        } else {
                            console.log(asset);
                            // modal action success
                            $('#preview-image').attr('src',
                                "{{ asset('storage/uploads/no-photo.png') }}");
                            $("#artikel-form")[0].reset()
                            $("#artikel-baru").modal('hide')

                            $("#row").prepend(
                                "<div class='col-md-4'><div class='card mt-3'>" +
                                "<img class='card-img-top' src='" + asset + response.image +
                                "' > " +
                                "<div class='card-body'>" +
                                "<a class='nav-link' href=''><i class='bi bi-heart'></i> Like</a>" +
                                "<p class='card-text mt-3'>" +
                                descriptionArtikel +
                                "</p></div></div></div>"
                            )

                            $("#no-article").html(
                                "<h5 class='position-absolute top-50 start-50 translate-middle'>" +
                                "</h5>"
                            )
                        }
                    }
                })
            })
        })
    </script>
@endsection
