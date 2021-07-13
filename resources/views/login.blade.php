<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Connexion</title>
        <link href="css/login.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/fonts/style.css') }}">
        <link href="css/bootstrap.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            body{
                font-family: 'Century Gothic Regular';
                background:url('assets/img/fluid.svg')no-repeat center center fixed;
                background-size: cover;
            }
        </style>
    </head>
    <body id="corps" class="btn-sm">
        <div class="col-sm-8 container-fluid align-center">
            <main>
                    <br><br>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <h3 id="titre">
                                    <img id="logo" src="assets/img/logo.jpg" alt="Logo UAC">
                                    <span id="texte">ESEU</span>
                                </h3>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-6" style="margin-bottom:-20px;">
                                @include('flash_message')
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="card shadow-lg border-0 rounded-lg mt-4" id="forms">
                                    <h4 class="text-center font-weight-light my-3">Connexion</h4>
                                    <div class="card-body">
                                        <form action="/login" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="small mb-1" for="login">
                                                    <i class="fa fa-user" aria-hidden="true"></i> Identifiant
                                                </label>
                                                <input class="form-control my-2 @error('login') is-invalid @enderror" name="login" id="login" type="text"  />
                                                @error('login')
                                                    <div class="invalid-feedback">
                                                        Veuiller entrer votre identifiant
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group row">
                                                <label class="small mb-1" for="mdp">
                                                    <i class="fa fa-lock" aria-hidden="true"></i> Mot de passe
                                                </label>
                                                <div class="input-group my-2" id="show_hide_password">
                                                <input class="form-control @error('pwd') is-invalid @enderror" type="password" name="pwd" id="pwd">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><a id="disp" href=""><i id="eye" class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
                                                </div>
                                                @error('pwd')
                                                    <div class="invalid-feedback">
                                                        Renseigner votre mot de passe
                                                    </div>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="row form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="/password" style="color: black;">Mot de passe oublié?</a>
                                                <button class="btn btn-sm" type="submit" style="color:black;background-color:white;" >Se connecter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-lg-6 btn-sm">
                                <footer>
                                  <div>Copyright &copy; ESEU 2020</div>
                                </footer>
                            </div>
                        </div>
                    </div>
        </main>
        </div>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/show_hide_pwd.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
