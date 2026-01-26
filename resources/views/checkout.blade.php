<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Checkout | Premium Technology Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>
<body>

  <div class="checkout-card">
    <a href="{{ route('cart.view') }}" class="card-link">
      <i class="fas fa-arrow-left-long"></i> Return to Cart
    </a>
    
    <h2>Finalize Order</h2>

    <form action="{{ route('checkout.process') }}" method="POST">
      @csrf
      
      <div class="order-summary">
        <h6>
            <span>Checkout Summary</span>
            <span class="text-xs bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full">{{ count($items) }} PRODUCTS</span>
        </h6>
        <div class="max-h-[140px] overflow-y-auto mb-2 custom-scroll pe-2">
            @foreach($items as $item)
            <div class="summary-item">
              <span>{{ $item['name'] }} <span class="text-xs font-bold px-1.5 py-0.5 bg-slate-100 rounded ml-1">x{{ $item['qty'] }}</span></span>
              <span class="text-slate-900 font-bold">{{ number_format($item['price'] * $item['qty'], 2) }} KHR</span>
            </div>
            @endforeach
        </div>
        <div class="summary-total">
          <div class="flex flex-col">
            <span class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black">Grand Total</span>
            <span>Total Payable</span>
          </div>
          <span>{{ number_format($total, 2) }} <small class="text-sm">KHR</small></span>
        </div>
      </div>

      <div class="form-group font-semibold">
        <label class="form-label"><i class="fas fa-id-card text-xs"></i> Recipient Name</label>
        <div class="input-container">
            <i class="fas fa-user-circle input-icon"></i>
            <input type="text" name="name" class="form-control w-100" placeholder="e.g. John Doe" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label"><i class="fas fa-phone-flip text-xs"></i> Contact Number</label>
        <div class="input-container">
            <i class="fas fa-mobile-screen-button input-icon"></i>
            <input type="tel" name="phone" class="form-control w-100" placeholder="012 345 678" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label"><i class="fas fa-house-chimney text-xs"></i> Delivery Address</label>
        <div class="input-container">
            <i class="fas fa-location-dot input-icon" style="top: 25px;"></i>
            <textarea name="location" class="form-control w-100" rows="3" placeholder="Building, Street, District, City..." required></textarea>
        </div>
      </div>

      <label class="form-label mb-3"><i class="fas fa-credit-card text-xs"></i> Select Payment</label>
      <div class="payment-options">
        <div class="payment-option">
          <input type="radio" name="payment_method" id="pay_khqr" value="khqr" required checked>
          <label for="pay_khqr">
            <i class="fas fa-qrcode text-indigo-500"></i>
            <span>KHQR SCAN</span>
          </label>
        </div>
        <div class="payment-option">
          <input type="radio" name="payment_method" id="pay_cod" value="cod">
          <label for="pay_cod">
            <i class="fas fa-hand-holding-dollar text-emerald-500"></i>
            <span>COD PAY</span>
          </label>
        </div>
      </div>

      <button type="submit" class="btn-checkout shadow-lg">
        <span>Complete My Purchase</span>
        <i class="fas fa-check-double"></i>
      </button>

      <div class="trust-section">
          <div class="trust-badges">
            <div class="trust-badge">
                <i class="fas fa-shield-halved"></i>
                <span>Secure</span>
            </div>
            <div class="trust-badge">
                <i class="fas fa-rotate-left"></i>
                <span>Refundable</span>
            </div>
            <div class="trust-badge">
                <i class="fas fa-headphones"></i>
                <span>Support</span>
            </div>
          </div>
          <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Encrypted Checkout & Guaranteed privacy</p>
      </div>
    </form>
  </div>

</body>
</html>


