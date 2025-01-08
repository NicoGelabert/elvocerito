<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color:#FBFCFF;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .social-icons {
            margin-top: 10px;
        }
        .social-icons a {
            margin: 0 5px;
            color: #ffffff;
            text-decoration: none;
            font-size: 20px;
        }
        .body {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .footer {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        .footer a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
    <title>Email de Confirmación</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="https://chimicreativo.es/storage/images/logo_chimi.png" alt="Logo de la Empresa" class="logo">
            <div class="social-icons">
                <a href="https://wa.me/34623037048" target="_blank">
                    <img src="https://chimicreativo.es/storage/images/WA_Logo.png" alt="Logo de la Empresa">
                </a>
                <a href="https://www.instagram.com/chimi.creativo/" target="_blank">
                    <img src="https://chimicreativo.es/storage/images/instagram.png" alt="Logo de la Empresa">
                </a>
               
            </div>
        </div>

        <!-- Body -->
        <div class="body">
            <h3>¡Gracias por Contactarnos!</h3>
            <p>Hola {{ $contact->name }},</p>
            <p>
                Gracias por completar nuestro formulario. Hemos recibido tu información y nos pondremos en contacto contigo a la brevedad. Si tienes alguna pregunta mientras tanto, no dudes en responder a este correo.
            </p>
            <p>Saludos cordiales,</p>
            <p><strong>Equipo de Atención al Cliente</strong><br><strong>Chimi Creativo</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2024 Chimi Creativo. Todos los derechos reservados.</p>
            <p>Fuengirola, Málaga</p>
            <p>Email: <a href="mailto:info@chimichimicreativo.es">info@chimicreativo.es</a></p>
        </div>
    </div>
</body>
</html>
