
<!DOCTYPE html>
<html>
<head>
        <title>Eseu - Administration</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/design.css') }}">
        <link rel="stylesheet" href="{{ asset('css/fonts/style.css') }}">
        <style>
            body{
                background-image:url('https://www.ird.fr/var/ird/storage/images/media/ird.fr/images/logos/partenaires/uac/80425-4-fre-FR/uac_medium.png')no-repeat center center fixed;
                background-size: cover;
            }
        </style>
</head>
<body style="padding:10px;">
    <div>
        <div>
            <h1 align="center" style="padding:20px;background-image: linear-gradient(cyan,white);" >
                <span>ESEU - Administration</span>
            </h1>
            <h2 align="center">Bonjour !</h2>
        </div>
        <div style="padding-left: 40px;padding-right:20px;">
            <p>
                Ce mail est adressé à Mr/Mme {{ $details['nom'].' '.$details['prenoms'] }} inscrit en Option {{ $details['option'] }} pour l'ESEU ( Examen Special d'Entré à l'Université)
                {{ $details['session'] }}.
                <br>Le calendrier des compositions prévu est le suivant :
                <ul>
                    <li>Epreuves orales : {{ $details['oral'] }}</li>
                    <li>Epreuves écrites : {{ $details['ecrit'] }}</li>
                </ul>
            </p>
            <p style="color:red;">
                <h5>NB: Ce calendrier est susceptible de subir des modifications qui vous serons notifié via mail ou alerte sms</h5>
            </p>
        </div>
        <div>
            <h5 align="center" style="padding:20px;background-image: linear-gradient(white,cyan);">Copyright ESEU - 2020 </h5>
        </div>
    </div>
</body>
</html>
