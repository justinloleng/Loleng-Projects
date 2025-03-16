@extends('navigation.sidebar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    @section('content')
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="container mt-4">
        <h1 class="mb-4">All Threads</h1>
        <form action="{{ route('threads.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search threads and authors here..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <a href="{{ route('threads.create') }}" class="btn btn-primary mb-3">Create New Thread</a>
        @if(count($threads) > 0)
        @foreach ($threads as $thread)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('threads.show', $thread->id) }}" class="text-decoration-none">{{ $thread->title }}</a>
                    </h5>
                    <p class="card-text">{{ Str::limit($thread->content, 100) }}</p>
                    <small class="text-muted">
                        Posted by <strong>{{ $thread->author }}</strong> on {{ $thread->created_at }}
                    </small>
    
                    @auth
                    @if(auth()->user()->id == $thread->user_id)
                        <div class="mt-2">
                            <a href="{{ route('threads.edit', $thread->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('threads.destroy', $thread->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
                </div>
            </div>
            
        @endforeach
        @else
        <p class="text-center text-muted">No threads found.</p>
     
        @endif
    </div>
    
    @endsection
    
    
</body>
</html>