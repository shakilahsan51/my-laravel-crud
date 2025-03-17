@extends('layouts.master')

@section('content')
    <div class="main-container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">All Posts</h4>
                <div class="float-end">
                    <a class="btn btn-success px-3 mx-4" href="{{ route('posts.create') }}">Create</a>
                    <a class="btn btn-warning" href="{{ route('posts.trashed') }}">Trashed</a>
                </div>
            </div>
    
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm">

                    <thead>
                      <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center" style="width:10%">Image</th>
                        <th scope="col" class="text-center" style="width:13%">Title</th>
                        <th scope="col" class="text-center" style="width:40%">Description</th>
                        <th scope="col" class="text-center" style="width:10%">Category</th>
                        <th scope="col" class="text-center" style="width:10%">Publish Date</th>
                        <th scope="col" class="text-center" style="width:30%">Action</th>
                      </tr>
                    </thead>

                    <tbody>

                      @foreach ($posts as $post)
                      <tr>
                        <th scope="row" class="text-center">{{ $post->id }}</th>
                        <td class="text-center"><img src="{{ asset('storage/'.$post->image) }}" alt="Post Image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;"></td>
                        <td class="text-center">{{ $post->title }}</td>
                        <td class="text-center">{{ $post->description }}</td>
                        <td class="text-center">{{ $post->category_id }}</td>
                        <td class="text-center">{{ date('d-m-y', strtotime($post->created_at)) }}</td>
                        <td class="text-center">
                          <div class="d-flex justify-content-center align-items-center gap-2">
                            <a class="btn btn-sm btn-success" href="{{ route('posts.show',$post->id) }}">Show</a>
                            <a class="btn btn-sm btn-primary px-3" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                            {{-- <a class="btn btn-sm btn-danger" href="">Delete</a> --}}

                            <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>

        </div>
    </div>
@endsection
