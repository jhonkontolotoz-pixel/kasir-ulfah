<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>POS</title>
   
        @vite(['resources/js/app.js','resources/css/app.css'])
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
       
<noscript>
    please enable js to continue
</noscript>
    </body>
</html>
