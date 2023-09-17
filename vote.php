<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /dc.php");
    exit;
}

$votes = file_get_contents("private/votes.json");
$votes = json_decode($votes, true);

foreach ($votes as $vote) {
    $user = hash("sha256", $_SESSION["user"]);
    if ($vote["user"] == $user) {
        header("Location: /?toast=alreadyvoted");
        exit;
    }
}


if (!isset($_SESSION["preference"]) && !isset($_GET["preference"]) && !isset($_GET["aday"])) {
    echo '
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@200;400;700&display=swap");

    @font-face {
        font-family: "Designer";
        src: url("/fonts/Designer.otf");
    }

    body {
        background-color: #1D2145;
        color: #fff;
        font-family: "Inter", sans-serif;
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

    .content {
        background-color: #0000009e;
        padding: 10px;
        width: 100vw;
        min-height: 100vh;
        backdrop-filter: blur(5px);
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
    </style>
    <body style="background-image: url(https://png.pngtree.com/background/20230525/original/pngtree-3d-paper-picture-image_2727027.jpg); background-position: center; background-size: cover; background-repeat: no-repeat; min-height: 100vh;">
    <div class="content">
    <a href="/" style="color: white;">geri</a>
    <center>
    <h1>Kekvland Seçim 2023-2024</h1>
    <br>
    Görmek istediğiniz seçim sayfasını seçin:<br><br><br>
    <a class="btn" href="?preference=1">3D Ultra Realistic Sayfa</a><br><br><br>
    <a class="btn" href="?preference=2">Temel Sayfa</a>
    </center>
    </div>
    </body>
    ';
    exit;
}

if (isset($_GET["preference"])) {
    if ($_GET["preference"] == "2") {
        header("Location: /votesimple.php");
        exit;
    }
}

if (isset($_GET["aday"])) {
    $aday = $_GET["aday"];
    $votes[] = [
        "user" => hash("sha256", $_SESSION["user"]),
        "aday" => $aday
    ];
    $votes = json_encode($votes);
    file_put_contents("private/votes.json", $votes);

    $voters = file_get_contents("private/voters.json");
    $voters = json_decode($voters, true);
    $voters[] = $_SESSION["username"];

    function scrambleArray($array)
    {
        $keys = array_keys($array);
        shuffle($keys);
        $new = array();
        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }
        ksort($new);
        return $new;
    }

    $voters = scrambleArray($voters);
    $voters = json_encode($voters);
    file_put_contents("private/voters.json", $voters);
    header("Location: /?toast=voted");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kekvland Seçim Sistemleri by Lera TicariMarka</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;400;700&display=swap');

        @font-face {
            font-family: "Designer";
            src: url("/fonts/Designer.otf");
        }

        body {
            margin: 0;
            overflow: hidden;
            background-image: url(https://img.freepik.com/free-photo/flat-lay-desk-arrangement-with-copy-space_23-2148928165.jpg);
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Roboto", sans-serif;
        }

        @media screen and (max-width: 768px) {
            body {
                overflow: auto;
            }
        }

        h1,
        h2 {
            font-family: "Roboto", sans-serif;
            margin: 0 !important;
        }

        .content {
            background-color: white;
            color: black;
            width: 100%;
            height: fit-content;
            padding: 10px;
            padding-bottom: 50px;
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

        .flex {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .aday {
            backdrop-filter: blur(5px);
            border-left: 1px black solid;
            border-right: 1px black solid;
            padding: 10px;
            margin: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .aday:first-child {
            border-left: none;
        }

        .aday:last-child {
            border-right: none;
        }

        .aday img {
            width: 200px;
            height: 200px;
            border: 1px black solid;
            object-fit: cover;
            object-position: center;
            margin-bottom: 10px;
        }

        .aday .btn {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 1px black solid;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .aday .btn:hover {
            background-image: url(https://www.technopat.net/sosyal/eklenti/evet-png.1777588/);
            background-size: cover;
            background-position: center;
        }

        .aday .btn-selected {
            background-image: url(https://www.technopat.net/sosyal/eklenti/evet-png.1777588/);
            background-size: cover;
            background-position: center;
        }

        .contentwrapper {
            width: 75%;
            height: fit-content;
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="contentwrapper" id="tilt">
    <a href="/vote.php" style="color: red;">geri</a>
        <div class="content" id="content">
            <center>
                <h1>CUMHURBAŞKANI ADAYLARI</h1>
            </center>
            <div class="flex">
                <?php
                $adaylar = glob("images/aday/*.{webp}", GLOB_BRACE);

                foreach ($adaylar as $aday) :
                ?>
                    <div class="aday">
                        <img draggable="false" src="/images/aday/<?= basename($aday) ?>" alt="">
                        <h3><?= basename($aday, ".webp") ?></h3>
                        <a href="/vote.php?aday=<?= basename($aday, ".webp") ?>" class="btn"> </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <button style="position: absolute; bottom: 10px; left:50%; transform: translateX(-50%); font-size: 24px" onclick="aply()">Gönder</button>


    <script>
        var aday = ""
        const buttons = document.querySelectorAll(".btn");
        buttons.forEach(button => {
            button.addEventListener("click", e => {
                e.preventDefault();
                aday = button.parentElement.querySelector("h3").textContent;
                buttons.forEach(btn => {
                    btn.classList.remove("btn-selected");
                });
                button.classList.add("btn-selected");
            });
        });

        document.addEventListener("click", e => {
            const img = document.createElement("img");
            img.src = "https://www.technopat.net/sosyal/eklenti/evet-png.1777588/";
            img.style.position = "absolute";
            var centered_x = e.pageX - 50;
            var centered_y = e.pageY - 50;
            img.style.left = centered_x + "px";
            img.style.top = centered_y + "px";
            img.style.width = "100px";
            img.style.height = "100px";
            img.style.objectFit = "cover";
            img.style.objectPosition = "center";
            img.style.transition = "all 0.3s ease";
            document.body.appendChild(img);
            setTimeout(() => {
                img.style.opacity = "0";
                img.style.transform = "scale(0.5)";
            }, 100);
            setTimeout(() => {
                img.remove();
            }, 500);
        });

        function aply() {
            if (aday == "") {
                alert("Lütfen bir aday seçin!");
                return;
            }
            if (!confirm(aday + " adayını seçtiniz. Seçiminizi onaylıyor musunuz?")) return;
            window.location.href = "/vote.php?aday=" + aday;
        }

        let el = document.getElementById('tilt')

        const height = el.clientHeight
        const width = el.clientWidth

        el.addEventListener('mousemove', handleMove)

        function handleMove(e) {
            const xVal = e.layerX
            const yVal = e.layerY
            const yRotation = 20 * ((xVal - width / 2) / width)

            const xRotation = -20 * ((yVal - height / 2) / height)

            const string = 'perspective(500px) scale(1.1) rotateX(' + xRotation + 'deg) rotateY(' + yRotation + 'deg)'

            el.style.transform = string
        }

        el.addEventListener('mouseout', function() {
            el.style.transform = 'perspective(500px) scale(1) rotateX(0) rotateY(0)'
        })

        el.addEventListener('mousedown', function() {
            el.style.transform = 'perspective(500px) scale(0.9) rotateX(0) rotateY(0)'
        })

        el.addEventListener('mouseup', function() {
            el.style.transform = 'perspective(500px) scale(1.1) rotateX(0) rotateY(0)'
        })
    </script>
</body>

</html>