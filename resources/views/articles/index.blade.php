@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
    @if (Session::has('status'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('message') }}
      </div>
    @endif

    <div class="d-flex mb-3">
      <div class="p-2"><h4>Article List</h4></div>
      <div class="ms-auto p-2">
        <a href={{ route('article.create') }} class="btn btn-success btn">
          Add
        </a>
      </div>
    </div>

    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Content</th>
          <th scope="col">Creator</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($articles as $item)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $item->title }}</td>
            <td>{{ $item->content }}</td>
            <td>{{ $item->creator->name }}</td>
            <td class="text-end">
              <a href={{ route('article.edit', $item->id) }} class="btn btn-info  btn-sm mb-1">
                Edit
              </a>
              <form action={{ route('article.destroy', $item->id) }} method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure ?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $articles->withQueryString()->links() }}
@endsection