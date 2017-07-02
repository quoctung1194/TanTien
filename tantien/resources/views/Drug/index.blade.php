@extends('Layout.master')

@section('title')
{{@__('index.drug')}}
@endsection

@section('javascript')
<script src="{{ TUrl::asset('js/drug/main.js') }}"></script>
@endsection

@section('content')
<span id="moduleInfo" controller="{{$controller}}" class="hidden"></span>
@endsection