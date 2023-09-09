<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="description" content="活動報名系統">
        <meta name="author" content="活動報名系統">

        <title inertia>{{ config('app.name', '活動報名系統') }}</title>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <noscript>
          <p>Activities</p>
          <p>活動報名系統</p>
          <p>您的瀏覽器不支援 JavaScript 或 JavaScript已停用，請先至您的瀏覽器設定中開啟 JavaScript</p>
        </noscript>
        <noscript>Your browser does not support JavaScript. If the webpage function is not working properly, please open the browser JavaScript status.</noscript>
    </body>
</html>
