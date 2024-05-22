@extends('layouts.app')
@section('links')
@endsection
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-8 offset-2">
                <h4>Edit Albums</h4>
                <form method="POST" action="{{ route('ablum.update', $album->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nameAlbum" class="form-label">Name Album</label>
                        <input type="text" name="name" class="form-control" id="nameAlbum" required
                            value="{{ $album->name }}">

                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>

    </div>
@endsection
