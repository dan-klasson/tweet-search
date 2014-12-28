@extends('layouts.master')

@section('title')
Error: {{ $error }}
@stop

@section('content')

<div class="alert alert-danger" role="alert">{{ $error }}</div>

@include('search_form')

@stop

