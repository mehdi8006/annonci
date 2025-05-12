<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Navigation</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        
        .sidebar99 {
            width: 250px;
            background-color: #ffffff;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
        }
        
        .profile99 {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 20px;
        }
        
        .profile-icon99 {
            width: 40px;
            height: 40px;
            background-color: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
        }
        
        .profile-name99 {
            font-weight: 600;
            color: #333;
        }
        
        .nav-links99 {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .nav-link99 {
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.2s, color 0.2s;
        }
        
        .nav-link99:hover {
            background-color: #f0f7ff;
            color: #3498db;
        }
        
        .nav-link99.active99 {
            background-color: #e6f2ff;
            color: #3498db;
            border-left: 3px solid #3498db;
        }
        
        .nav-link99 i {
            margin-right: 10px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        .logout99 {
            margin-top: auto;
            border-top: 1px solid #eaeaea;
            padding-top: 10px;
        }
        
        .main-content99 {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="sidebar99">
        <div class="profile99">
            <div class="profile-icon99">U</div>
            <div class="profile-name99">Username</div>
        </div>
        
        <div class="nav-links99">
            <a href="#" class="nav-link99">
                <i class="fas fa-plus-circle"></i>
                Publier une annonce
            </a>
            <a href="#" class="nav-link99 active99">
                <i class="fas fa-list"></i>
                Mes annonces
            </a>
            <a href="#" class="nav-link99">
                <i class="fas fa-heart"></i>
                Mes favoris
            </a>
            <a href="#" class="nav-link99">
                <i class="fas fa-cog"></i>
                Paramètres
            </a>
            
            <a href="#" class="nav-link99 logout99">
                <i class="fas fa-sign-out-alt"></i>
                Se déconnecter
            </a>
        </div>
    </div>
    
    <div class="main-content99">
        Content Area
    </div>
</body>
</html>