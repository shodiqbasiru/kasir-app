<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Website POS</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <div class="container-fluid p-0 m-0" id="app">
        <app></app>
    </div>


    <script type="text/javascript">
        window.vueSpatiePermissions = {!! auth()->check()
            ? auth()->user()->getRolesPermissionsAsJson()
            : '[]' !!};
    </script>

</body>


</html>
