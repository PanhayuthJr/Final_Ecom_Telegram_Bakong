<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment QR</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- // Axios for potential future use --}}
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
 

  <style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #f1f2f6, #dfe4ea);
    margin: 0;
    padding: 15px;
  }

  .qr-card {
    background: #ffffff;
    padding: 30px 20px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    text-align: center;
    width: 100%;
    max-width: 340px;
    animation: fadeInUp 0.5s ease;
  }

  .qr-card h2 {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #2f3542;
  }

  .timer {
    font-size: 1.1rem;
    margin-bottom: 15px;
    color: #ff4757;
    font-weight: 600;
  }

  #qrcode {
    margin: 15px auto;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 12px;
    display: inline-block;
  }

  .price {
    font-size: 1.3rem;
    margin-top: 18px;
    font-weight: 700;
    color: #2ed573;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(15px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Mobile optimization */
  @media (max-width: 576px) {
    .qr-card {
      padding: 25px 15px;
    }

    .qr-card h2 {
      font-size: 1.4rem;
    }

    .price {
      font-size: 1.2rem;
    }
  }
  .payment-logo {
  width: 120px;
  max-width: 100%;
  margin: 10px auto 15px;
  display: block;
  object-fit: contain;
}
</style>

</head>
<body>


    <div class="qr-card">
    <h2>Scan Now to Pay</h2>
    <div class="timer" id="timer">03:00</div>
     <img 
    src="{{ asset('image/KHQR.png') }}" 
    alt="Payment Logo" 
    class="payment-logo">
    <div id="qrcode"></div>
    <div class="price">Amount :{{ $price }}KHR</div>
    <input type="hidden" name="md5" value="{{ $qrData['md5'] }}">
  </div>

  {{-- <div class="container mt-5 mb-5">
    <div class="row">
      <center>
        <div class="col-6">
          <h2>Scan To Pay Now</h2>
          <div class="timer" id="timer">03:00</div>
          <div id="qrcode"></div>
          <div class="price">Amount :${{ $price }}</div>
          <input type="hidden" name="md5" value="{{ $qrData['md5'] }}">
        </div>
      </center>
    </div>
  </div>

  --}}
  <script>

    const qrElement = document.getElementById("qrcode");

    // Generate QR code
    let qrCode = new QRCode(qrElement, {
      text: "{{ $qrData['qr'] }}",
      width: 250,
      height: 250,
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

      if (timeLeft < 0) {
        clearInterval(countdown);
        timerEl.textContent = "QR Expired";
        qrElement.innerHTML = ""; // Remove QR code
        // Optional: show message or disable payment
        const expiredMsg = document.createElement("div");
        expiredMsg.textContent = "Please refresh the page to generate a new QR code.";
        expiredMsg.style.color = "#ff4757";
        expiredMsg.style.marginTop = "15px";
        qrElement.appendChild(expiredMsg);
      }
    }, 1000);


    // Polling for payment status every 3 seconds
    const checkPaymentStatus = setInterval(() => {

      let url = "{{ '/check-transaction-status' }}?md5={{ $qrData['md5'] }}";
      axios.get(url)
      .then(function(response){
        if (response.data.paid === true) {
          clearInterval(checkPaymentStatus);
          // Optionally redirect or update UI
          window.location.href = "{{ url('/payment-success') }}"; // Redirect to home or another page
        }
        console.log(response.data);
      }
  )
      .catch(function(error){
        console.log(error);
      });
    }, 3000);
  </script>

</body>
</html>