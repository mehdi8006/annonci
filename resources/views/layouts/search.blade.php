<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'Annonces - Annoncia</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
<body class="">
    <!-- Include the navigation bar component -->
    @include('components.nav')
    
    <!-- Main content container -->
    <div class="main-container">
        @yield('content')
    </div>
        @include('components.footer')

</body>
</html>