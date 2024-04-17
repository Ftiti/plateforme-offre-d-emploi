<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre inscription</title>
</head>
<body>
    <h1>Bienvenue, {{ $user->name }}!</h1>
    <p>Veuillez utiliser le code suivant pour valider votre adresse e-mail :</p>
    <p>{{ $verificationCode }}</p>
    <p>Merci de vous être inscrit!</p>
</body>
</html>
