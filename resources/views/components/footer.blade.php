<style>
 .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2563eb;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideInLeft 0.6s ease forwards;
        }
    .footer {
        background-color: #ffffff;
        padding: 40px 5% 20px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        font-size: 15px;
        color: #4b5563;
        margin-top: 60px;
        animation: fadeIn 0.6s ease forwards;
    }
    
    .footer-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .footer-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .footer-logo {
        height: 36px;
        border-radius: 8px;
    }
    
    .footer-brand {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2563eb;
    }
    
    .footer-links {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    
    .footer-links a {
        color: #4b5563;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .footer-links a:hover {
        color: #2563eb;
    }
    
    .footer-socials a {
        color: #6b7280;
        margin-left: 12px;
        font-size: 18px;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .footer-socials a:hover {
        color: #2563eb;
        transform: scale(1.1);
    }
    
    .footer-bottom {
        text-align: center;
        border-top: 1px solid #e5e7eb;
        padding-top: 15px;
        font-size: 14px;
        color: #6b7280;
    }
    
    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
            align-items: flex-start;
        }
    
        .footer-socials {
            margin-top: 12px;
        }
    }
    
    </style>
    
    <footer class="footer">
        <div class="footer-container">
            <div class="logo-text">
                <i class="fa-solid fa-bag-shopping"></i> Annoncia
            </div>
    
            <div class="footer-links">
                <a href="#">À propos</a>
                <a href="#">Contact</a>
                <a href="#">Confidentialité</a>
                <a href="#">Conditions</a>
            </div>
    
            <div class="footer-socials">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div> 
    
        <div class="footer-bottom">
            <p>&copy; 2025 Nova. Tous droits réservés.</p>
        </div>
    </footer>
    