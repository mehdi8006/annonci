<style>
    .purchase-flow-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px;
        background-color: #f8f9fa;
    }
    
    .flow-title {
        text-align: center;
        margin-bottom: 10px;
        font-size: 42px;
        color: #333;
        font-weight: bold;
    }
    
    .flow-subtitle {
        text-align: center;
        margin-bottom: 50px;
        font-size: 20px;
        color: #777;
        font-weight: normal;
    }
    
    .process-flow {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 40px;
        position: relative;
    }
    
    .process-step {
        flex: 1;
        min-width: 180px;
        height:320px;

        margin: 20px;
        background-color: white;
        padding: 30px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .process-step:hover {
        transform: translateY(-10px);
    }
    
    .step-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #0c2aea;
        color: white;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 5px 15px rgba(27, 12, 234, 0.3);
    }
    
    .step-number {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: #333;
        color: white;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        font-weight: bold;
    }
    
    .step-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }
    
    .step-description {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
    }
    
    .connecting-line {
        position: absolute;
        height: 2px;
        background-color: #1e0cea;
        top: 80px;
        z-index: 0;
    }
    
   
    
    .
    
    @media (max-width: 1024px) {
        .process-step {
            flex: 0 0 calc(50% - 40px);
        }
        
    }
    
    @media (max-width: 600px) {
        .process-step {
            flex: 0 0 100%;
            margin: 10px 0;
        }
        
        
    }
</style>

<div class="purchase-flow-container">
    <h2 class="flow-title">Comment acheter sur Annoncia?</h2>
    <p class="flow-subtitle">Un processus simple et sécurisé pour vos transactions</p>
    
    <div class="process-flow">
        <div class="connecting-line" style="width: calc(100% - 200px); left: 100px;"></div>
        
        <div class="process-step" style="z-index: 1;">
            <div class="step-number">1</div>
            <div class="step-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="step-title">Choisir un produit</h3>
            <p class="step-description">Trouvez l'annonce qui correspond à vos besoins parmi notre large sélection</p>
        </div>
        
        <div class="process-step" style="z-index: 1;">
            <div class="step-number">2</div>
            <div class="step-icon">
                <i class="fas fa-phone"></i>
            </div>
            <h3 class="step-title">Contacter le vendeur</h3>
            <p class="step-description">Utilisez le téléphone ou la messagerie intégrée pour joindre le vendeur</p>
        </div>
        
        <div class="process-step" style="z-index: 1;">
            <div class="step-number">3</div>
            <div class="step-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="step-title">Négociation</h3>
            <p class="step-description">Discutez du prix, de l'état du produit et du mode de remise ou livraison</p>
        </div>
        
        <div class="process-step" style="z-index: 1;">
            <div class="step-number">4</div>
            <div class="step-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <h3 class="step-title">Paiement</h3>
            <p class="step-description">Payez selon le mode convenu entre vous et le vendeur</p>
        </div>
        
        <div class="process-step" style="z-index: 1;">
            <div class="step-number">5</div>
            <div class="step-icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <h3 class="step-title">Livraison</h3>
            <p class="step-description">Recevez le produit par remise en main propre ou livraison selon l'accord</p>
        </div>
    </div>
    
</div>