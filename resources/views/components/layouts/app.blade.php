<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ request()->is('self-order*') ? 'Self Order' : 'Cafity' }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
    <style>
      body {
          font-family: 'Montserrat', sans-serif;
      }
      .navbar-brand .self-order-text {
          font-size: 24px;
          font-weight: bold;
          margin-left: 10px;
      }
    </style>
  </head>
  <body style="background-color: #f0f8ff">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="{{ asset('logo.jpg') }}" alt="Logo Baru" style="height: 40px;">
            <span class="self-order-text">Self Order</span>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav>
      
      @if (!request()->is('self-order*'))
        <a href="{{url('/self-order')}}" type="button" class="btn btn-light mt-4 {{ request()->is('self-order*', '') || request()->is('/') ? 'active' : '' }}">Self Order</a>
      @endif
      
      @if (!request()->is('self-order*') && !request()->is('/'))
        <a href="{{url('/product')}}" type="button" class="btn btn-light mt-4 {{ request()->is('product*') ? 'active' : '' }}">Produk</a>
        <a href="{{url('/order')}}" type="button" class="btn btn-light mt-4 {{ request()->is('order*') ? 'active' : '' }}">Daftar Order</a>
      @endif
        
      {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>