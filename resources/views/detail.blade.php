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
   @if ($page=='show')
    @section('main')
   <x-home.detailscarte :userAds="$userAds" :add="$add" :ads="$detailsAds" :isFavorite="$isFavorite" />   
   @endsection
       
   @endif
  
   @if ($page=='member')
    @section('main')
   <x-home.detailscartem :ads="$detailsAds" :isFavorite="$isFavorite" />   
   @endsection   
   @endif
  
</body>
</html>