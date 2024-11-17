<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>Ruangan</title>
    <style>

    </style>
</head>
<body>
<div class="" x-data="{isClicked:false}" x-cloak>
    <button x-on:click="isClicked=!isClicked">hey</button>
    <p x-show="isClicked">clicked</p>
</div>
</body>
</html>
