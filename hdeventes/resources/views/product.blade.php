@extends('layout.main')

@section('title', 'Product')

@section('content')
    @if($id)
    <p> Exibindo o produto {{$id}}<p>
    @else
     <p> Não existe o produto </p>
    @endif
@endsection
