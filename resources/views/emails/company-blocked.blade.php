<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre entreprise a été bloquée</title>
    <style>
        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .content p {
            margin: 16px 0;
            color: #334155;
            line-height: 1.6;
        }
        .alert-box {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .alert-box p {
            margin: 0;
            color: #991b1b;
        }
        .support-box {
            background-color: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .support-box p {
            margin: 0;
            color: #0c4a6e;
        }
        .support-box .email {
            font-weight: bold;
            color: #0284c7;
            word-break: break-all;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
        }
        .action-btn {
            display: inline-block;
            background-color: #0284c7;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Votre entreprise a été bloquée</h1>
        </div>
        
        <div class="content">
            <p>Bonjour,</p>
            
            <p>Nous vous informons que votre entreprise <strong>"{{ $company->name }}"</strong> a été bloquée par l'administrateur système.</p>
            
            <div class="alert-box">
                <p>Votre compte n'est plus actif et vous ne pouvez plus vous connecter à votre tableau de bord.</p>
            </div>
            
            <p>Pour plus d'informations ou pour contester cette décision, veuillez contacter l'administrateur système :</p>
            
            <div class="support-box">
                <p><strong>Support Administrateur</strong></p>
                <p class="email">{{ $superAdmin->email }}</p>
            </div>
            
            <p>Cordialement,<br>
            <strong>L'équipe d'administration</strong></p>
        </div>
        
        <div class="footer">
            <p>Cet email a été généré automatiquement. Veuillez ne pas répondre directement à cet email.</p>
        </div>
    </div>
</body>
</html>
