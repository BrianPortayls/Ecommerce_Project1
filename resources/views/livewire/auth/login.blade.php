<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--ink);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: var(--surface);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }
        .login-form input {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid var(--line);
            border-radius: 4px;
            width: 100%;
        }
        .login-form button {
            background-color: var(--green);
            color: var(--surface);
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: var(--green-dark);
        }
        .login-footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
        .login-footer a {
            color: var(--blue);
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Welcome Back</h1>
        <p class="text-center text-muted">Enter your credentials to continue</p>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <input type="email" name="email" placeholder="Email address" required autofocus>

            <!-- Password -->
            <input type="password" name="password" placeholder="Password" required>

            <!-- Remember Me -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit">Log in</button>
        </form>

        <div class="login-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            <p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
        </div>
    </div>
</body>
</html>
