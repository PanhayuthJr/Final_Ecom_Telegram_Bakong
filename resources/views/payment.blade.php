<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment QR</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary-color: #4361ee;
      --success-color: #06d6a0;
      --warning-color: #ffd166;
      --danger-color: #ef476f;
      --dark-color: #2b2d42;
      --light-color: #f8f9fa;
      --gradient-start: #6a11cb;
      --gradient-end: #2575fc;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated background elements */
    .bg-shapes {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
    }

    .shape {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
    }

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      top: 10%;
      left: 10%;
      animation: float 20s infinite linear;
    }

    .shape:nth-child(2) {
      width: 120px;
      height: 120px;
      top: 60%;
      right: 10%;
      animation: float 25s infinite linear reverse;
    }

    .shape:nth-child(3) {
      width: 60px;
      height: 60px;
      bottom: 20%;
      left: 20%;
      animation: float 15s infinite linear;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(0deg);
      }
      50% {
        transform: translateY(-20px) rotate(180deg);
      }
    }

    .qr-container {
      width: 100%;
      max-width: 420px;
      animation: fadeInUp 0.6s ease-out;
    }

    .qr-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 35px 30px;
      border-radius: 24px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
      text-align: center;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .qr-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
    }

    .qr-header {
      margin-bottom: 25px;
    }

    .qr-header h2 {
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 5px;
      color: var(--dark-color);
      background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .qr-header p {
      font-size: 1rem;
      color: #6c757d;
      font-weight: 500;
    }

    .timer-container {
      background: rgba(239, 71, 111, 0.1);
      padding: 12px 20px;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      margin-bottom: 25px;
      border: 2px solid rgba(239, 71, 111, 0.2);
    }

    .timer-container i {
      color: var(--danger-color);
      margin-right: 10px;
      font-size: 1.2rem;
    }

    .timer {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--danger-color);
      letter-spacing: 1px;
    }

    .payment-logo {
      width: 140px;
      margin: 10px auto 20px;
      display: block;
      filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.1));
    }

    .qr-wrapper {
      position: relative;
      margin: 20px auto;
      width: 260px;
      height: 260px;
      padding: 15px;
      background: white;
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: center;
      align-items: center;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    #qrcode {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .qr-wrapper::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 18px;
      border: 2px dashed rgba(67, 97, 238, 0.2);
      top: 0;
      left: 0;
      pointer-events: none;
    }

    .amount-container {
      background: linear-gradient(to right, rgba(6, 214, 160, 0.1), rgba(67, 97, 238, 0.1));
      padding: 18px;
      border-radius: 16px;
      margin: 25px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .amount-label {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--dark-color);
    }

    .amount-value {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--success-color);
      display: flex;
      align-items: center;
    }

    .amount-value i {
      margin-right: 8px;
      font-size: 1.4rem;
    }

    .payment-info {
      background: #f8f9fa;
      padding: 18px;
      border-radius: 16px;
      margin-top: 20px;
      text-align: left;
    }

    .payment-info h5 {
      font-size: 1rem;
      color: var(--dark-color);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }

    .payment-info h5 i {
      margin-right: 8px;
      color: var(--primary-color);
    }

    .payment-info p {
      font-size: 0.9rem;
      color: #6c757d;
      line-height: 1.5;
    }

    .status-indicator {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 20px;
      padding: 12px;
      border-radius: 12px;
      background: rgba(67, 97, 238, 0.05);
      transition: all 0.3s ease;
    }

    .status-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: var(--warning-color);
      margin-right: 10px;
      animation: pulse 2s infinite;
    }

    .status-text {
      font-weight: 600;
      color: var(--dark-color);
    }

    @keyframes pulse {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0.5;
      }
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

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .expired {
      animation: shake 0.5s;
    }

    /* Mobile optimization */
    @media (max-width: 576px) {
      .qr-card {
        padding: 30px 20px;
        margin: 10px;
      }

      .qr-header h2 {
        font-size: 1.5rem;
      }

      .qr-wrapper {
        width: 230px;
        height: 230px;
      }

      .amount-value {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Background shapes -->
  <div class="bg-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <div class="qr-container">
    <div class="qr-card">
      <div class="qr-header">
        <h2><i class="fas fa-qrcode me-2"></i>Scan to Pay Now</h2>
        <p>Scan the QR code with your banking app</p>
      </div>

      <div class="timer-container">
        <i class="fas fa-clock"></i>
        <div class="timer" id="timer">03:00</div>
      </div>

      <img 
        src="{{ asset('image/KHQR.png') }}" 
        alt="Payment Logo" 
        class="payment-logo">

      <div class="qr-wrapper">
        <div id="qrcode"></div>
      </div>

      <div class="amount-container">
        <div class="amount-label">Payment Amount</div>
        <div class="amount-value"><i class="fas fa-money-bill-wave"></i>{{ $price }} KHR</div>
      </div>

      <div class="payment-info">
        <h5><i class="fas fa-info-circle"></i> Payment Instructions</h5>
        <p>1. Open your banking app<br>
           2. Tap on QR code scanning feature<br>
           3. Point your camera at this QR code<br>
           4. Confirm the payment amount and complete transaction</p>
      </div>

      <div class="status-indicator" id="statusIndicator">
        <div class="status-dot"></div>
        <div class="status-text">Waiting for payment...</div>
      </div>

      <input type="hidden" name="md5" value="{{ $qrData['md5'] }}">
    </div>
  </div>

  <script>
    // Generate QR code
    const qrElement = document.getElementById("qrcode");
    let qrCode = new QRCode(qrElement, {
      text: "{{ $qrData['qr'] }}",
      width: 220,
      height: 220,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });

    // Timer setup (3 minutes = 180 seconds)
    let timeLeft = 180;
    const timerEl = document.getElementById("timer");

    const countdown = setInterval(() => {
      let minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;
      // format as MM:SS
      timerEl.textContent = `${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
      timeLeft--;

      // Change timer color when less than 30 seconds
      if (timeLeft < 30) {
        timerEl.style.color = "#ff4757";
        timerEl.parentElement.style.animation = "pulse 1s infinite";
      }

      if (timeLeft < 0) {
        clearInterval(countdown);
        timerEl.textContent = "00:00";
        timerEl.parentElement.classList.add("expired");
        timerEl.parentElement.style.background = "rgba(239, 71, 111, 0.2)";
        timerEl.parentElement.style.borderColor = "rgba(239, 71, 111, 0.3)";
        
        // Update status indicator
        const statusIndicator = document.getElementById("statusIndicator");
        statusIndicator.innerHTML = `
          <div style="background: #ef476f; width: 12px; height: 12px; border-radius: 50%; margin-right: 10px;"></div>
          <div class="status-text">QR Code Expired</div>
        `;
        
        // Show expired message
        const expiredMsg = document.createElement("div");
        expiredMsg.innerHTML = `
          <div style="background: #fff5f7; padding: 15px; border-radius: 12px; margin-top: 15px; border-left: 4px solid #ef476f;">
            <div style="font-weight: 600; color: #ef476f; margin-bottom: 5px;">
              <i class="fas fa-exclamation-triangle me-2"></i>QR Code Expired
            </div>
            <div style="color: #6c757d; font-size: 0.9rem;">
              Please refresh the page to generate a new QR code.
            </div>
          </div>
        `;
        qrElement.parentElement.appendChild(expiredMsg);
        
        // Clear the QR code
        qrElement.innerHTML = "";
      }
    }, 1000);

    // Polling for payment status every 3 seconds
    const checkPaymentStatus = setInterval(() => {
      let url = "{{ '/check-transaction-status' }}?md5={{ $qrData['md5'] }}";
      axios.get(url)
        .then(function(response) {
          console.log("Payment status:", response.data);
          
          if (response.data.paid === true) {
            clearInterval(checkPaymentStatus);
            clearInterval(countdown);
            
            // Update UI to show success
            const statusIndicator = document.getElementById("statusIndicator");
            statusIndicator.innerHTML = `
              <div style="background: #06d6a0; width: 12px; height: 12px; border-radius: 50%; margin-right: 10px;"></div>
              <div class="status-text" style="color: #06d6a0;">
                <i class="fas fa-check-circle me-2"></i>Payment Successful!
              </div>
            `;
            
            // Add success animation to QR code
            qrElement.parentElement.style.boxShadow = "0 10px 30px rgba(6, 214, 160, 0.3)";
            qrElement.parentElement.style.border = "2px solid #06d6a0";
            
            // Show success message
            const successMsg = document.createElement("div");
            successMsg.innerHTML = `
              <div style="background: #f0f9f6; padding: 15px; border-radius: 12px; margin-top: 15px; border-left: 4px solid #06d6a0;">
                <div style="font-weight: 600; color: #06d6a0; margin-bottom: 5px;">
                  <i class="fas fa-check-circle me-2"></i>Payment Received
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">
                  Thank you for your payment! Redirecting...
                </div>
              </div>
            `;
            qrElement.parentElement.appendChild(successMsg);
            
            // Redirect after 2 seconds
            setTimeout(() => {
              window.location.href = "{{ route('checkout.success') }}";
            }, 2000);
          }
        })
        .catch(function(error) {
          console.log("Error checking payment status:", error);
        });
    }, 3000);
  </script>
</body>
</html>