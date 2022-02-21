@extends('layouts.app')

@section('content')
<!-- カルーセル -->
<div class="container-fluid no-gutters">
    <div class="row">
        <div id="cl" class="carousel slide w-100" data-ride="carousel" data-pause="false">
            <ol class="carousel-indicators">
                <li data-target="#cl" data-slide-to="0" class="active"></li>
                <li data-target="#cl" data-slide-to="1"></li>
                <li data-target="#cl" data-slide-to="2"></li>
                <li data-target="#cl" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner carousel-fade">
                <div class="carousel-item active">
                    <img src="{{ asset('images/top-1.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-2.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-3.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-4.jpg') }}" class="d-block w-100" alt="">
                </div>
            </div>
            <a class="carousel-control-prev" href="#cl" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#cl" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    こんにちは！
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
