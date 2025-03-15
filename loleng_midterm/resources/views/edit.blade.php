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
        <h1>Edit Thread</h1>
        <form action="{{ route('threads.update', $thread->id) }}" method="POST" class="mt-3">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Thread Title</label>
                <input type="text" name="title" class="form-control" value="{{ $thread->title }}" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="4" required>{{ $thread->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Thread</button>
        </form>
    </div>    
    @endsection
</body>
</html>