
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
        }


        .footer-simple {
            background: white;
            border-top: 1px solid var(--border-light);
            margin-top: 4rem;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .footer-brand:hover {
            color: var(--primary-dark);
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            align-items: center;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-socials {
            display: flex;
            gap: 1rem;
            justify-content: center;
            align-items: center;
        }

        .social-link {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .footer-bottom {
            background: var(--bg-light);
            border-top: 1px solid var(--border-light);
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .footer-socials {
                margin-top: 1rem;
            }
        }
    </style>
<body>
    <footer class="footer-simple">
        <div class="container py-4">
            <div class="row g-4 align-items-center">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6 text-center text-md-start">
                    <a href="#" class="footer-brand">
                        <i class="fa-solid fa-bag-shopping"></i>
                        Annoncia
                    </a>
                </div>
                
                <!-- Links Section -->
                <div class="col-lg-4 col-md-6">
                    <nav class="footer-links">
                        <a href="#">À propos</a>
                        <a href="#">Contact</a>
                        <a href="#">Confidentialité</a>
                        <a href="#">Conditions</a>
                    </nav>
                </div>
                
                <!-- Social Media Section -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-socials">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright Section -->
        <div class="footer-bottom">
            <div class="container py-3">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">
                            © 2025 Nova. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
