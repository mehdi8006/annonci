
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #f97316;
            --secondary-dark: #ea580c;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8fafc;
            --border-light: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

       

        .process-section {
            background-color: var(--bg-light);
            padding: 5rem 0;
        }

        .process-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .process-title {
            font-size: clamp(2rem, 4vw, 3rem);
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .process-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .process-step {
            background: white;
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            text-align: center;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-md);
            height: 100%;
            position: relative;
            transition: all 0.3s ease;
        }

        .process-step:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .step-number {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: var(--text-dark);
            color: white;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -1.25rem;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .step-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2rem auto 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .step-description {
            font-size: 1rem;
            line-height: 1.6;
            color: var(--text-muted);
        }

        /* Connecting Line */
        .connecting-line {
            position: absolute;
            height: 2px;
            background: var(--primary-color);
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .connecting-line {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .process-section {
                padding: 3rem 0;
            }
            
            .process-header {
                margin-bottom: 3rem;
            }
            
            .process-step {
                margin-bottom: 2rem;
            }
            
            .step-icon {
                width: 3.5rem;
                height: 3.5rem;
                font-size: 1.25rem;
                margin: 1.5rem auto 1rem;
            }
        }
    </style>
<body>
    <section class="process-section">
        <div class="container">
            <!-- Header -->
            <div class="process-header">
                <h2 class="process-title">Comment acheter sur Annoncia?</h2>
                <p class="process-subtitle">Un processus simple et sécurisé pour vos transactions</p>
            </div>
            
            <!-- Process Steps -->
            <div class="row g-4 position-relative">
                <!-- Connecting Line for Desktop -->
                
                <!-- Step 1 -->
                <div class="col-12 col-md-6 col-xl-2-4">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="step-title">Choisir un produit</h3>
                        <p class="step-description">Trouvez l'annonce qui correspond à vos besoins parmi notre large sélection</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="col-12 col-md-6 col-xl-2-4">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="step-title">Contacter le vendeur</h3>
                        <p class="step-description">Utilisez le téléphone ou la messagerie intégrée pour joindre le vendeur</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="col-12 col-md-6 col-xl-2-4">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="step-title">Négociation</h3>
                        <p class="step-description">Discutez du prix, de l'état du produit et du mode de remise ou livraison</p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="col-12 col-md-6 col-xl-2-4">
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h3 class="step-title">Paiement</h3>
                        <p class="step-description">Payez selon le mode convenu entre vous et le vendeur</p>
                    </div>
                </div>
                
                <!-- Step 5 -->
                <div class="col-12 col-md-6 col-xl-2-4">
                    <div class="process-step">
                        <div class="step-number">5</div>
                        <div class="step-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="step-title">Livraison</h3>
                        <p class="step-description">Recevez le produit par remise en main propre ou livraison selon l'accord</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom CSS for 5-column layout -->
    <style>
        @media (min-width: 1200px) {
            .col-xl-2-4 {
                flex: 0 0 auto;
                width: 20%;
            }
        }
    </style>

    <!-- Bootstrap JS -->
</body>
