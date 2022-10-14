@extends('layouts.layout')

@section('title', 'Creator - Data Baru')

@section('content')
    @if (Session::has('status'))
      <div class="alert alert-danger" role="alert">
          {{ Session::get('message') }}
      </div>
    @endif

    <div class="d-flex mb-3">
      <div class="p-2"><h4>Pengarang Baru</h4></div>
      <div class="ms-auto p-2">
        <a href={{ route('creator') }} class="btn btn-danger">
          Batal
        </a>
      </div>
    </div>

    <form action={{ route('creator.store') }} method="POST" >
      @csrf
      <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        placeholder="Nama Pengarang" value="{{ old('name') }}">
        <label for="name">Nama Pengarang</label>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection