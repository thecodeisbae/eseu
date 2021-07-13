@extends('layout')
@section('content')
<main>
                    <div class="container-fluid">
                        <h3 class="mt-4">Accueil</h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Accueil</li>
                        </ol>
                         <div class="row justify-content-center">
                            <div class="col-lg-12">
                                @include('flash_message')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <div class="card-title">Option A1</div>
                                        <hr color="white">
                                        <div class="card-text">
                                            <p>
                                                Nombres d'inscrits : <span style="font-size: 150%;">{{ $data['a1'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/chart">Voir détails</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <div class="card-title">Option A2</div>
                                        <hr color="white">
                                        <div class="card-text">
                                            <p>
                                                Nombres d'inscrits : <span style="font-size: 150%;">{{ $data['a2'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/chart">Voir détails</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">
                                        <div class="card-title">Option B</div>
                                        <hr color="white">
                                        <div class="card-text">
                                            <p>
                                                Nombres d'inscrits : <span style="font-size: 150%;">{{ $data['b'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/chart">Voir détails</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <div class="card-title">Option C</div>
                                        <hr color="white">
                                        <div class="card-text">
                                            <p>
                                                Nombres d'inscrits : <span style="font-size: 150%;">{{ $data['c'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/chart">Voir détails</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
@endsection
