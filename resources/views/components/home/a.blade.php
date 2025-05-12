
    <style>
        
      

        .banner0 {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            max-width: 1200px;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .banner0::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2b3dff, #e54a1f);
        }

        .text0 h1 {
            color: #2c3e50;
            font-size: clamp(1.5rem, 2.5vw, 1.5rem);
            font-weight: 650;
            margin-bottom: 20px;
            line-height: 2;
        }

        .highlight0 {
            color: #ff5c2b;
            position: relative;
            display: inline-block;
        }

        .highlight0::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: -2px;
            right: -2px;
            height: 8px;
            background-color: rgba(255, 92, 43, 0.1);
            z-index: -1;
            transform: skew(-12deg);
        }

        .tagline0 {
            color: #64748b;
            font-size: 1.3rem;
            margin-bottom: 48px;
            font-weight: 500;
        }

        .cta-container0 {
            display: flex;
            gap: 24px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-button0 {
            background-color: #ff5c2b;
            color: #ffffff;
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.125rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .cta-button0:hover {
            background-color: #e54a1f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 92, 43, 0.3);
        }

        .cta-button0:active {
            transform: translateY(0);
        }
        
        

       

        

        @media (max-width: 768px) {
           

            
            .cta-container0 {
                flex-direction: column;
            }

            .cta-button0 {
                width: 100%;
                justify-content: center;
            }
        }

        /* Decorative elements */
        .decoration0 {
            position: absolute;
            opacity: 0.05;
            pointer-events: none;
        }

        .decoration-10 {
            top: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            background-color: #ff5c2b;

            border-radius: 50%;
        }

        .decoration-20 {
            bottom: 20px;
            left: 20px;
            width: 80px;
            height: 80px;
            background-color: #ff5c2b;
            border-radius: 8px;
            transform: rotate(45deg);
        }
    </style>
</head>
<body>
    <main class="banner0">
        <div class="decoration0 decoration-10"></div>
        <div class="decoration0 decoration-20"></div>
       <div class="text0">
         <h1>Achetez, vendez, <span class="highlight0">échangez</span> – facilement et rapidement.</h1>
        
        <p class="tagline0">La marketplace qui simplifie tous vos échanges</p>
        </div> 
       
        <div class="cta-container0">
            <button class="cta-button0">
                <i class="fa-solid fa-square-plus"></i>
                Déposer une annonce
            </button>
            
        </div>
    </main>
</body>
</html>