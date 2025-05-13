<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'Annonces - Annoncia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
        }
        
        /* Reset links */
        a {
            text-decoration: none;
            color: inherit;
        }
        
        /* Container styles */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body class="{{ session()->has('user_id') ? 'user-logged-in' : '' }}">
    <!-- Include the navigation bar component -->
    @include('components.nav')
    
    <!-- Main content container -->
    <div class="main-container">
        @yield('content')
    </div>
</body>
</html>