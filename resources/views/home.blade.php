<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@extends('layouts.masterhome')
@section('main')
<x-home.a/>
<x-home.scrollingcarte :ads="$recentAds" :cat="null" :add="$add" :title="'Plus récent'"/>

@foreach($categoryAds as $data)
    <x-home.scrollingcarte :ads="$data['ads']" :add="$add" :cat="$data['category']" :title="$data['category']->nom" />
@endforeach
<x-home.b/>
@endsection

</body>
</html>