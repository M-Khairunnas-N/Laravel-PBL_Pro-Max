<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('img/logo_posyandu.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
          rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Sistem Informasi Posyandu</title>
    <style>
        *, html {
            font-family: 'Plus Jakarta Sans'
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var countdown = 5;
            var countdownElement = document.getElementById("countdown");

            var interval = setInterval(function() {
                countdownElement.textContent = countdown;
                countdown--;

                if (countdown < 0) {
                    clearInterval(interval);
                    window.history.back();
                }
            }, 1000);
        });
    </script>
</head>
<body>
    <div class="w-full h-screen flex flex-col justify-center items-center bg-white dark:bg-blue-950 font-normal text-lg gap-5">
        <img src="{{ asset('img/404 Error Page not Found with people connecting a plug-pana.svg') }}" alt="" class="w-1/4 h-auto">
        <p>Anda akan dikembalikan dalam <span id="countdown" class="text-red-600">5</span> atau klik <span onclick="back()" class="text-blue-700 cursor-pointer">kembali</span></p>
    </div>

    <script>
        function back() {
            window.history.back();
        }
    </script>
</body>
</html>