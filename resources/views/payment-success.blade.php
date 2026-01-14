<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful | Thank You</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .thankyou-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
            padding: 50px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Decorative elements */
        .thankyou-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
        }
        
        .thankyou-container::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(79, 172, 254, 0.05);
            border-radius: 50%;
            transform: translate(50px, -50px);
        }
        
        .checkmark-container {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            position: relative;
            animation: checkmarkScale 0.5s ease-out;
        }
        
        .checkmark {
            color: white;
            font-size: 50px;
            font-weight: bold;
            animation: checkmarkDraw 0.5s ease-out 0.2s both;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5rem;
            animation: fadeInUp 0.5s ease-out 0.4s both;
        }
        
        .success-message {
            color: #666;
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 40px;
            animation: fadeInUp 0.5s ease-out 0.6s both;
        }
        
        .payment-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
            text-align: left;
            animation: fadeInUp 0.5s ease-out 0.8s both;
            border-left: 4px solid #4facfe;
        }
        
        .payment-details h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .payment-details h3 i {
            color: #4facfe;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .detail-item {
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: #333;
            font-size: 1rem;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
            border: none;
            cursor: pointer;
            animation: fadeInUp 0.5s ease-out 1s both;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.4);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            opacity: 0;
        }
        
        .additional-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
            animation: fadeInUp 0.5s ease-out 1.2s both;
        }
        
        /* Animations */
        @keyframes checkmarkScale {
            0% { transform: scale(0); }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        @keyframes checkmarkDraw {
            0% { transform: scale(0) rotate(45deg); opacity: 0; }
            100% { transform: scale(1) rotate(0); opacity: 1; }
        }
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        /* Responsive design */
        @media (max-width: 600px) {
            .thankyou-container {
                padding: 40px 25px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .btn {
                padding: 14px 30px;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 400px) {
            .thankyou-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <div class="checkmark-container">
            <div class="checkmark">✔</div>
        </div>
        <h1>អរគុណ​ អរគុណ​ អរគុណ​</h1>
        <p class="success-message">
            Your payment was processed successfully.<br>
            We appreciate your trust in us. A confirmation email has been sent to your inbox.
        </p>
        
        <div class="payment-details">
            <h3><i class="fas fa-receipt"></i> Payment Details</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-label">Transaction ID</div>
                    <div class="detail-value">TXN-789456123</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value" id="currentDateTime"></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Amount Paid</div>
                    <div class="detail-value">{{$price}}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Payment Method</div>
                    <div class="detail-value">Abatukam</div>
                </div>
            </div>  
        </div>
        
        <a href="/" class="btn">
            <i class="fas fa-home"></i> Back to Home
        </a>
        
        <p class="additional-info">
            Need help? Contact our support team at support@example.com or call (123) 456-7890.
        </p>
    </div>

    <script>
        // Set current date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
        }
        
        // Add some confetti effect
        function createConfetti() {
            const container = document.querySelector('.thankyou-container');
            const colors = ['#4facfe', '#00f2fe', '#ff6b6b', '#ffd93d', '#6bcf7f'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = Math.random() * 100 + '%';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = confetti.style.width;
                confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                confetti.style.opacity = '0';
                
                container.appendChild(confetti);
                
                // Animate confetti
                setTimeout(() => {
                    confetti.style.transition = 'all 1s ease-out';
                    confetti.style.opacity = '0.7';
                    confetti.style.transform = `translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) rotate(${Math.random() * 360}deg)`;
                    
                    // Remove confetti after animation
                    setTimeout(() => {
                        confetti.style.opacity = '0';
                        setTimeout(() => {
                            if (confetti.parentNode) {
                                confetti.parentNode.removeChild(confetti);
                            }
                        }, 1000);
                    }, 3000);
                }, i * 50);
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDateTime();
            
            // Trigger confetti after a short delay
            setTimeout(createConfetti, 500);
            
            // Add hover effect to the checkmark
            const checkmarkContainer = document.querySelector('.checkmark-container');
            checkmarkContainer.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            checkmarkContainer.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>