<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Professional Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .header {
            background: #4a6de5;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            font-weight: 600;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .form-container {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: 500;
            font-size: 15px;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 40px;
            color: #777;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            border-color: #4a6de5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 109, 229, 0.2);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #4a6de5, #6e80f0);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(74, 109, 229, 0.3);
        }

        .btn:hover {
            background: linear-gradient(to right, #3d5dc7, #5c75e0);
            box-shadow: 0 6px 15px rgba(74, 109, 229, 0.4);
            transform: translateY(-2px);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            font-size: 14px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
        }

        .forgot-password {
            color: #4a6de5;
            text-decoration: none;
            font-weight: 500;
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #777;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .separator::before {
            margin-right: .5em;
        }

        .separator::after {
            margin-left: .5em;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 15px;
        }

        .register-link a {
            color: #4a6de5;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 500px) {
            .remember-forgot {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Login Account</h1>
        </div>

        <div class="form-container">

            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="remember-forgot">
                    <div class="remember">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" id="loginButton" class="btn">Login</button>

                <div class="separator">Or continue with</div>
                <div class="register-link">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                </div>
            </form>


        </div>
    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script>
        $(document).ready(function() {
            // attach submit event to form, not button
            $("#loginForm").on("submit", function(e) {
                
                e.preventDefault();

                let email = $("#email").val();
                let password = $("#password").val();

                $.ajax({
                    url: '/api/login',
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false, // important for JSON
                    data: JSON.stringify({
                        email: email,
                        password: password
                    }),
                    success: function(response) {
                        console.log(response);

                        localStorage.setItem('api_token', response.token);
                        window.location.href = "{{ route('allpost') }}";
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr.responseText);
                    }
                });
            });
        });

    </script>




</body>
</html>
