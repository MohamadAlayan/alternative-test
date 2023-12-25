@extends('emails.layouts.default')

@section('title', 'Password Reset')

@section('content')
    <p>{{__('emails.hello',['name' => $fullName])}}</p>

    <p>{{__('emails.reset_password.line_1')}}</p>

    <p>{{__('emails.reset_password.line_2')}}</p>

    <a href="{{ url('password/reset/'.$token) }}">{{__('emails.reset_password.action_button')}}</a>

    <p>{{__('emails.reset_password.line_3',['count' => $expiryTime])}}</p>

    <p>{{__('emails.reset_password.line_4')}}</p>

    <i>{{__('emails.reset_password.ignore_message')}}</i>

    <p>{{__('emails.regards')}}</p>
@endsection
