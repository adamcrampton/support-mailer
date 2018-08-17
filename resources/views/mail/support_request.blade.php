<!doctype html>
  <head>
    <title>Support Request</title>
  </head>
  <body>   
    <p>Hello {{ $provider }},</p>
    <p>This is {{ $first_name }} {{ $last_name }}, and I need help with:
    <ul>
      <li>{{ $issue }}</li>
    </ul>
    <p>Here are my details:</p>
    <ul>
    	<li>Email address: {{ $email }}</li>
    	<li>Phone number: {{ $phone }}</li>
    	<li>Preferred contact method: {{ $preferred_contact }}</li>
    </ul>
    <p>A description of the problem is as follows:</p>
    <p>{{ $details }}</p>
  </body>
</html>