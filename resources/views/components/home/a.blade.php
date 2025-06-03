
    <style>
        :root {
            --coral: #ff7b7b;
            --coral-light: #ffb3b3;
            --blue: #4a90e2;
            --blue-light: #7bb3f0;
            --orange: #ff6b35;
            --orange-dark: #e55a2b;
            --text-dark: #2c3e50;
            --white: #ffffff;
        }

      
        .hero-section {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -20%;
            width: 60%;
            height: 80%;
            background: linear-gradient(45deg, var(--coral), var(--coral-light));
            border-radius: 50% 60% 70% 40%;
            opacity: 0.8;
            animation: float 6s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 10%;
            right: -15%;
            width: 50%;
            height: 70%;
            background: linear-gradient(135deg, var(--blue), var(--blue-light));
            border-radius: 40% 70% 60% 50%;
            opacity: 0.9;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
        }

        .hero-title {
            font-size: clamp(1.75rem, 4.2vw, 3.15rem);
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 3rem;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .cta-button {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: var(--white);
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 107, 53, 0.4);
            color: var(--white);
        }

        .cta-button i {
            font-size: 1.3rem;
        }

        /* Additional floating elements */
        .floating-shape {
            position: absolute;
            opacity: 0.6;
            animation: floatRandom 10s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 60px;
            height: 60px;
            background: var(--coral);
            border-radius: 50%;
            animation-delay: -2s;
        }

        .floating-shape:nth-child(2) {
            bottom: 30%;
            right: 20%;
            width: 40px;
            height: 40px;
            background: var(--blue);
            border-radius: 50%;
            animation-delay: -4s;
        }

        @keyframes floatRandom {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
            }
            25% {
                transform: translateY(-15px) translateX(10px);
            }
            50% {
                transform: translateY(-10px) translateX(-5px);
            }
            75% {
                transform: translateY(-20px) translateX(15px);
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                padding: 1rem;
            }
            
            .hero-title {
                margin-bottom: 2rem;
            }
            
            .cta-button {
                padding: 1rem 2rem;
                font-size: 1rem;
            }
        }
    </style>

    <section class="hero-section">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                C'est le moment de vendre
            </h1>
            
            <a href="{{ route('member.annonces.create') }}" class="cta-button">
                <i class="fa-solid fa-plus"></i>
                Déposer une annonce
            </a>
        </div>
    </section>

