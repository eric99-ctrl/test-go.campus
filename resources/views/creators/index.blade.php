@extends('layouts.layout')

@section('title', 'Creator')

@section('content')
    @if (Session::has('status'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('message') }}
      </div>
    @endif

    <div class="d-flex mb-1">
      <div class="p-2"><h4>Daftar Pengarang</h4></div>
      <div class="ms-auto p-2">
        <a href={{ route('creator.create') }} class="btn btn-success btn">
          Tambah
        </a>
      </div>
    </div>

    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Pengarang</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($creators as $item)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $item->name }}</td>
            <td class="text-end">
              <a href={{ route('creator.edit', $item->id) }} class="btn btn-info  btn-sm mb-1">
                Ubah
              </a>
              <form action={{ route('creator.destroy', $item->id) }} method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Apakah Anda yakin akan menghapus data ini ?')">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @endforeach

      </tbody>
    </table>
    {{ $creators->withQueryString()->links() }}
@endsection