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
    
    <div class="container d-flex justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 rounded-3">
                <h2 class="text-center mb-4">Create a New Thread</h2>
                <form action="{{ route('threads.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Thread Title</label>
                        <input type="text" name="title" class="form-control rounded-3 border-0 shadow-sm" placeholder="Enter thread title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea name="content" class="form-control rounded-3 border-0 shadow-sm" rows="5" placeholder="Write your content here" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill">Create Thread</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>