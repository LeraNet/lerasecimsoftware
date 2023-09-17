<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kekvland Seçim Sistemleri by Lera TicariMarka</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;400;700&display=swap');

        @font-face {
            font-family: "Designer";
            src: url("/fonts/Designer.otf");
        }

        body {
            background-color: #1D2145;
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        h1,
        h2 {
            margin: 0 !important;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        p {
            text-align: center;
            margin-top: 30px;
            font-size: 18px;
        }

        ul {
            padding: 0;
            margin-top: 30px;
        }

        li {
            margin: 0;
        }

        a {
            color: #ff0000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #ff6666;
        }

        .content {
            background-color: #0000009e;
            padding: 10px;
            width: 100vw;
            min-height: 100vh;
            backdrop-filter: blur(5px);
        }

        .big {
            font-family: 'Designer', sans-serif;
            font-weight: 100;
            font-size: 10vw;
            margin-top: 0;
            margin-bottom: 0;
        }

        .flex {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20vh;
        }

        .ajans {
            background-color: #0000009e;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            width: 300px;
            height: 300px;
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .ajans:hover {
            transform: scale(1.1);
        }

        .ajans img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
            background-color: white;
            border-radius: 10px;
            padding: 1px;
            transition: all 0.3s ease;
        }

        .ajans img:hover {
            transform: scale(1.1);
        }

        .ajans img:active {
            transform: scale(0.9);
        }

        .ajans h3 {
            margin: 0;
            font-size: 20px;
        }

        .btn {
            background-color: #ff0000;
            color: #fff;
            padding: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin: 10px;
        }

        .btn:hover {
            transform: scale(1.1);
        }

        .btn:active {
            transform: scale(0.9);
        }

        .banner {
            background-color: #0000009e;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            width: 50%;
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            animation: glow 1s infinite;
        }

        .banner h2 {
            margin: 0;
            font-size: 20px;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 10px #ff0000;
            }

            50% {
                box-shadow: 0 0 20px #ff0000;
            }

            100% {
                box-shadow: 0 0 10px #ff0000;
            }
        }

        .footer {
            height: 20vh;
            background-color: black;
            margin: -25px;
            margin-top: 20px;
        }
    </style>
</head>

<body style="background-image: url(https://png.pngtree.com/background/20230525/original/pngtree-3d-paper-picture-image_2727027.jpg); background-position: center; background-size: cover; background-repeat: no-repeat; min-height: 100vh;">
    <div class="content">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <a href="/" style="color: white;">geri</a>
        <center>
            <h1>Kekvland Seçim 2023-2024</h1>
            <h2 class="big">Ajanslar:</h2>
        </center>
        <div class="flex">
            <div class="ajans">
                <img src="/images/libtv.png" alt="">
                <h3>TV Liberal</h3>
                <a href="/ajans.php?ajans=libtv" class="btn">İzle</a>
            </div>
            <div class="ajans">
                <img src="/images/trtkurdi.png" alt="">
                <h3>TRT Kurdi</h3>
                <a href="/ajans.php?ajans=trtkurdi" class="btn">İzle</a>
            </div>
            <div class="ajans">
                <img src="/images/hktv.png" alt="">
                <h3>HK TV</h3>
                <a href="/ajans.php?ajans=hktv" class="btn">İzle</a>
            </div>
        </div>
    </div>
</body>

</html>