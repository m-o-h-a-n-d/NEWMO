<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You Are Blocked!</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#dc3545">

    <!-- Bootstrap (اختياري لو بتستخدمه) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.7s ease-out forwards;
        }

        .animate-scale-in {
            animation: scale-in 0.5s ease-out forwards;
        }

        .animate-pulse {
            animation: pulse 1.5s infinite ease-in-out;
        }

        .center-page {
            padding-top: 100px;
            padding-bottom: 60px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff, #f2f2f2);
        }

        .blocked-card {
            max-width: 500px;
            width: 100%;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .btn-danger:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="center-page animate-fade-in">
        <div class="card shadow-lg p-4 blocked-card">
            <div class="text-center">
                <div class="mb-4 animate-scale-in animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="red"
                        class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                        <path
                            d="M11.46.146a.5.5 0 0 1 .353.146l4 4a.5.5 0 0 1 .146.353v6.707a.5.5 0 0 1-.146.353l-4 4a.5.5 0 0 1-.353.146H4.54a.5.5 0 0 1-.353-.146l-4-4A.5.5 0 0 1 0 11.207V4.5a.5.5 0 0 1 .146-.353l4-4A.5.5 0 0 1 4.54 0h6.92ZM6.146 5.146a.5.5 0 1 0-.708.708L7.293 8l-1.855 1.854a.5.5 0 0 0 .708.708L8 8.707l1.854 1.855a.5.5 0 0 0 .708-.708L8.707 8l1.855-1.854a.5.5 0 1 0-.708-.708L8 7.293 6.146 5.146Z" />
                    </svg>
                </div>
                <h2 class="text-danger fw-bold" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                    You Are Blocked from this System
                </h2>
                <p class="text-muted mt-2">
                    Your account has been blocked by the administration.<br>
                    Please contact support if you believe this decision is a mistake.
                </p>
                <a href="{{ route('frontend.contact.index') }}" class="btn btn-danger mt-4 px-4 py-2 fw-semibold">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</body>

</html>
