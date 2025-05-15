<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact - NATT-APP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #4e73df;
            display: inline-block;
            width: 80px;
        }
        .message-content {
            white-space: pre-line;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nouveau message de contact - NATT-APP</h2>
    </div>
    
    <div class="content">
        <div class="detail-item">
            <span class="label">De :</span>
            {{ $details['name'] }} ({{ $details['email'] }})
        </div>
        
        <div class="detail-item">
            <span class="label">Sujet :</span>
            {{ $details['subject'] }}
        </div>
        
        <div class="detail-item">
            <span class="label">Message :</span>
            <div class="message-content">
                {{ $details['body'] }}
            </div>
        </div>
        
        <div class="detail-item">
            <span class="label">Statut :</span>
            Utilisateur vérifié (connecté)
        </div>
    </div>
    
    <div class="footer">
        <p>Ce message a été envoyé depuis l'interface de contact de NATT-APP</p>
        <p>© {{ date('Y') }} NATT-APP - Tous droits réservés</p>
    </div>
</body>
</html>