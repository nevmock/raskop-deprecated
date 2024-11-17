@extends('layouts.mainlayout')
@section('content')
<div>
    @isset($slot)
        {{ $slot }}
    @endisset
</div>
@endsection
