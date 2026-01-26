<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | TechPremium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <a href="{{ route('home') }}" class="back-home">
        <i class="fas fa-arrow-left"></i> Back to Catalog
    </a>

    <div class="login-card">
        <a href="{{ route('home') }}" class="logo">Tech<span>Premium</span></a>
        <h1>Welcome Back</h1>
        <p class="subtitle">Enter your credentials to access your curations</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Sign In</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Create Selection</a>
        </div>
    </div>
</body>
</html>
