@extends('layouts.layout')

@section('title', 'Article - Create')

@section('content')
    @if (Session::has('status'))
      <div class="alert alert-danger" role="alert">
          {{ Session::get('message') }}
      </div>
    @endif

    <div class="d-flex mb-3">
      <div class="p-2"><h4>New Article</h4></div>
      <div class="ms-auto p-2">
        <a href={{ route('article') }} class="btn btn-danger">
          Back/Cancel
        </a>
      </div>
    </div>

    <form action={{ route('article.store') }} method="POST" enctype="multipart/form-data" >
      @csrf
      <div class="form-floating mb-3">
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        placeholder="Title" value="{{ old('title') }}">
        <label for="title">Title</label>
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="form-floating mb-3">
        <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content"
        placeholder="Content" value="{{ old('content') }}">
        <label for="name">Content</label>
        @error('content')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="form-floating mb-3">
        <select class="form-select @error('creator_id') is-invalid @enderror" id="creator_id" name="creator_id" aria-label="Floating label select example">
          <option selected></option>
          @foreach ($creators as $item)
            <option value="{{ $item->id }}" @selected(old('creator_id') == $item->id)>{{ $item->name }}</option>
          @endforeach
        </select>
        <label for="creator">Creator</label>
        @error('creator_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-3">
          <img src="{{ asset('image/preview.png') }}" alt="Preview" id="preview" width="150" height="170">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
      const preview = document.querySelector('#preview');
      const image = document.querySelector('#image');

      image.addEventListener('change', function(){
            preview.src="{{ asset('image/preview.png') }}";
            const file = image.files[0];

            if (file) {
              preview.src =  URL.createObjectURL(file);
            }
      });

    </script>

@endsection