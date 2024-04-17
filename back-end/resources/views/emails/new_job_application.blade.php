<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle candidature</title>
</head>
<body>
    <h1>Nouvelle candidature</h1>
    <p>Bonjour Administrateur,</p>
    <p>Une nouvelle candidature a été soumise. Voici les détails :</p>
    <ul>
        <li>Nom : {{ $user->name }}</li>
        <li>Email : {{ $user->email }}</li>
    </ul>
    <p>Veuillez trouver ci-joint le CV du candidat.</p>
</body>
</html>
