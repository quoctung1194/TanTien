@extends('Layout.master')

@section('title')
{{@__('index.drugOrder')}}
@endsection

@section('content')
<span id="moduleInfo" controller="{{$controller}}" class="hidden"></span>
@endsection