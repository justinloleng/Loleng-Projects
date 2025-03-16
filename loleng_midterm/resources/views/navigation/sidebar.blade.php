<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: white;
            font-size: 18px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

 
    <div class="sidebar">
        <h3 class="text-center text-light">THE BROS FORUM</h3>
        <br>
        <a href="{{ route('threads.index') }}">📌 All Threads</a>
        <a href="{{ route('threads.create') }}">➕ Create Thread</a>
        <a href="{{route('user.edit')}}">⚙️ User Settings</a>
        <a href="{{ route('logout') }}">🚪 Logout</a>
    </div>
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
