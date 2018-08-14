@extends('layouts.base')

@section('title', 'Support Mailer')

@section('content')
  <p>Config:</p>

  <ul>
    <li>Intro HTML is: {{ $config->intro_html }}</li>
    <li>Default provider is: {{ $config->provider->provider_name }}</li>
    <li>Show multiple providers? {{ $config->show_multiple_providers }}</li>
    <li>Use staff list? {{ $config->use_staff_list }}</li>
  </ul>

  @if ($config->show_multiple_providers)
    <p>Provider List (if enabled):</p>
    <ul>
    @foreach ($providers as $provider)
      <li>{{ $provider->provider_name }}</li>
    @endforeach
    </ul>
  @endif

  <p>List of issue types in database:</p>
  <ul>
    @foreach ($issueList as $issue)
      <li>{{ $issue->issue_name }}</li>
    @endforeach
    </ul>

  @if ($config->use_staff_list)
    <p>Staff List (if enabled):</p>
    <ul>
    @foreach ($staffMembers as $staffMember)
      <li>{{ $staffMember->staff_name }}, {{ $staffMember->staff_email }}</li>
    @endforeach
    </ul>
  @endif
@endsection
