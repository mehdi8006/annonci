<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   @extends('layouts.masterhome') 
  
   @section('main')
        @if ($page=='log')
        <x-auth.auth />

        @endif
        @if ($page=='forgot')
        <x-auth.forgotpwd/>
        @endif
   @endsection
</body>
</html>