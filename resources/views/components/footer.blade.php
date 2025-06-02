<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #f97316;
            --secondary-dark: #ea580c;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
            --bg-light: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .footer-modern {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-top: 1px solid var(--border-light);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .footer-brand-modern {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease forwards;
        }

        .footer-brand-modern:hover {
            color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .footer-brand-modern i {
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links-modern {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            align-items: center;
        }

        .footer-links-modern a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-links-modern a:hover {
            color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .footer-links-modern a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .footer-links-modern a:hover::after {
            width: 80%;
        }

        .footer-socials-modern {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }

        .social-link-modern {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .social-link-modern:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-3px) scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .social-link-modern.facebook:hover {
            background: #1877f2;
            border-color: #1877f2;
        }

        .social-link-modern.twitter:hover {
            background: #1da1f2;
            border-color: #1da1f2;
        }

        .social-link-modern.instagram:hover {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            border-color: #e6683c;
        }

        .social-link-modern.linkedin:hover {
            background: #0077b5;
            border-color: #0077b5;
        }

        .footer-bottom-modern {
            background: rgba(59, 130, 246, 0.02);
            border-top: 1px solid var(--border-light);
            color: var(--text-light);
            font-size: 0.875rem;
            font-weight: 400;
        }

        .footer-copyright-modern {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .footer-copyright-modern i {
            color: var(--primary-color);
        }

        /* Animation for footer content */
        .footer-content-animate {
            animation: fadeInUp 0.8s ease forwards;
        }

        .footer-content-animate:nth-child(2) {
            animation-delay: 0.2s;
        }

        .footer-content-animate:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-links-modern {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .footer-links-modern a {
                padding: 0.75rem 1.5rem;
                width: 100%;
                text-align: center;
                border-radius: 0.75rem;
            }
            
            .footer-socials-modern {
                margin-top: 1.5rem;
                gap: 1.5rem;
            }
            
            .social-link-modern {
                width: 3rem;
                height: 3rem;
            }
        }

        /* Decorative Elements */
        .footer-decoration {
            position: absolute;
            opacity: 0.03;
            pointer-events: none;
            z-index: 0;
        }

        .footer-decoration-1 {
            top: 2rem;
            right: 2rem;
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .footer-decoration-2 {
            bottom: 2rem;
            left: 2rem;
            width: 60px;
            height: 60px;
            background: var(--secondary-color);
            border-radius: 0.5rem;
            transform: rotate(45deg);
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <footer class="footer-modern">
        <!-- Decorative Elements -->
        <div class="footer-decoration footer-decoration-1"></div>
        <div class="footer-decoration footer-decoration-2"></div>
        
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6 text-center text-md-start">
                    <div class="footer-content-animate">
                        <a href="#" class="footer-brand-modern">
                            <i class="fa-solid fa-bag-shopping"></i>
                            Annoncia
                        </a>
                    </div>
                </div>
                
                <!-- Links Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-content-animate">
                        <nav class="footer-links-modern">
                            <a href="#">À propos</a>
                            <a href="#">Contact</a>
                            <a href="#">Confidentialité</a>
                            <a href="#">Conditions</a>
                        </nav>
                    </div>
                </div>
                
                <!-- Social Media Section -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-content-animate">
                        <div class="footer-socials-modern">
                            <a href="#" class="social-link-modern facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link-modern twitter" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link-modern instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link-modern linkedin" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright Section -->
        <div class="footer-bottom-modern">
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <p class="footer-copyright-modern">
                            <i class="fa-regular fa-copyright"></i>
                            2025 Nova. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>