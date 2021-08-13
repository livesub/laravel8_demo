@extends('layouts.head')

@section('content')






<table border="1">
    <tr>
        <td><h4>{{ $menu_name_kr }}</h4></td>
    </tr>
</table>

<table border="1">
    <tr>
        <td>{!! $menu_content !!}</td>
    </tr>
</table>




@endsection
