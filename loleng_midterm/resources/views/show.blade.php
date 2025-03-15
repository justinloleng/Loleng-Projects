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
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $thread->title }}</h2>
                <p class="card-text">{{ $thread->content }}</p>
                <small class="text-muted">
                    Posted by <strong>{{ $thread->author }}</strong> on {{ $thread->created_at }}
                </small>
            </div>
        </div>
    
        <h4 class="mt-4">Replies</h4>
        @foreach ($replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ $reply->content }}</p>
                <small class="text-muted">
                    Posted by <strong>{{ $reply->author }}</strong> on {{ $reply->created_at }}
                </small>
    
                @auth
                    @if(auth()->user()->id == $reply->user_id)
                        <div class="mt-2">
                            <a href="{{ route('replies.edit', $reply->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" class="d-inline">
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
    
    
        <h4 class="mt-4">Add a Reply</h4>
        <form action="{{ route('replies.store', $thread->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Reply</label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Reply</button>
        </form>
    </div>
    @endsection
    
    
</body>
</html>