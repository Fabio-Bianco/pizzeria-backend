<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria - Menu Pubblico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 50px;
            color: white;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        h1 { font-size: 2.5em; margin-bottom: 20px; }
        p { font-size: 1.2em; margin-bottom: 30px; }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i data-lucide="pizza" style="width: 40px; height: 40px; color: #ef4444; vertical-align: middle; margin-right: 8px;"></i> Benvenuto alla Pizzeria</h1>
        <p>Il menu pubblico è in fase di sviluppo.<br>
        Per ora, accedi al backoffice per gestire il contenuto.</p>
        <a href="{{ route('login') }}" class="btn">
            Accedi al Backoffice
        </a>
    </div>
</body>
</html>