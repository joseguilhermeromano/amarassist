<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon">
    <title>AMAR ASSIST</title>
    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
