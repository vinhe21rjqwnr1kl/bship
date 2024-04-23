{{ __('A person want to contact you:') }} <br>
{{ __('Name:') }} {{ $data['first_name'] }} {{ $data['last_name'] }} <br/>
{{ __('Email:') }} {{ $data['email'] }} <br/>
{{ __('Phone Number:') }} {{ $data['phone_number'] }} <br/>
{{ __('Message:') }} {!! $data['message'] !!}