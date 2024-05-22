@extends('layouts.app')
@section('links')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h3>{{ $album->name }} </h3>

            @if (isset($pictures) && count($pictures) > 0)
                <div class="row text-center">
                    @foreach ($pictures as $picture)
                        <div class="col-4 " style="height: 400px">
                            <img class="img-thumbnail w-100 h-75" src="{{ url('/') . '/' . $picture->path }}" alt="">
                            <a href="{{ route('picture.delete', $picture->id) }}" class="btn btn-danger btn-sm">delete</a>
                            <a href="#" class="move btn btn-primary btn-sm">Move TO</a>

                            <form action="{{ route('picture.change.album', $picture->id) }}" method="get"
                                class="mt-2 form-move d-none" id="form-move">
                                <label for="">choose album</label>
                                <select name="album" id="">
                                    <option disabled>choose album</option>
                                    @foreach ($all_albums as $item)
                                        <option @if ($item->id == $picture->album_id) style="color:green" selected @endif
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" value="Save" />
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="col-8 offset-2">
                    <div class="alert alert-danger mt-5">No pictures in this Album.<br />
                        you to add pictures.
                    </div>
            @endif


            <div class="col-8 offset-2">

                <h3 class="mt-5">Add pictures</h3>

                <form method="POST" action="{{ route('pictures.store', $album->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="file" name="images[]" required class="form-control" id="inputGroupFile02" multiple="multiple"
                            accept="image/jpeg, image/png, image/jpg">

                        <label class="input-group-text" for="inputGroupFile02">Upload</label>

                    </div>
                    @error('images')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        $('.move').click(function() {
            $(this).next().toggleClass('d-none');
        });
    </script>
@endsection
