<?php
$ajans = $_GET["ajans"] ?? null;

if ($ajans == null || !file_exists("data/$ajans.json")) {
    header("Location: /?toast=ajansyok");
    die("Ajans Seçin");
}

$data = json_decode(file_get_contents("data/$ajans.json"), true);

$allVotes = 0;

for ($i = 0; $i < count($data["adaylar"]); $i++) {
    $allVotes = $allVotes + $data["oylar"][$data["adaylar"]["$i"]];
}


$sandik = round(($allVotes / $data["sunucu_uyesayisi"]) * 100);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kekvland Seçim Sistemleri by Lera TicariMarka</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="background-image: url(<?= $data["theme"]["background"] ?>); background-position: center; background-size: cover; background-repeat: no-repeat; min-height: 100vh; margin: 0">
    <div style="backdrop-filter: blur(10px); min-height: 100vh; width: 100%; padding: 10px; background-color: rgba(0,0,0, 0.5)">
        <a href="/ajanslar.php" style="color: white;">geri</a>
        <br>
        <p id="debug" <?php if (!isset($_COOKIE["debug"])) {
                            echo "style='display: none'";
                        } ?>>
            -----Debug----- <button onclick="document.getElementById('debug').style.display = 'none'; cokilebenibebegim()">x</button> <br>
            Ama abi bu 100% olmuyoki :DDDDDD <br>
            Son Kontrol Edildi : <span id="ms"></span></p>
        <div class="adaylar">
            <center>
                <img class="logo" src="images/<?= $ajans ?>.png" alt="" srcset="" draggable="false">
            </center>
            <h1 style="text-align: center;">CUMHURBAŞKANI SEÇİMİ 1. TUR</h1>
            <h2 style="text-align: center;">Açılan Sandık : <span id="acilan-sandik">0</span></h2>
            <div class="fr">
                <?php
                foreach ($data["adaylar"] as $aday) :
                ?>
                    <div class="aday">
                        <h3><?= $aday ?></h3>
                        <div class="xd">
                            <img src="/images/aday/<?= $aday ?>.webp" alt="" draggable="false">
                            <div class="yuzde" id="<?= $aday ?>-yuzde">
                                <?= round(($data["oylar"]["$aday"] / $data["sunucu_uyesayisi"]) * 100); ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script>
        let last = 0;
        let ses = false;

        function updateData() {
            fetch('data/<?= $ajans ?>.json?' + Math.random(0, 999))
                .then(response => response.json())
                .then(data => {
                    const adaylar = data.adaylar;
                    const oylar = data.oylar;
                    const sunucuUyeSayisi = data.sunucu_uyesayisi;

                    let totalVotes = 0;

                    adaylar.forEach(aday => {
                        totalVotes += oylar[aday];
                    });

                    adaylar.forEach(aday => {
                        const yuzdeDiv = document.getElementById(`${aday}-yuzde`);
                        if (oylar[aday] == 0) {
                            let prev = yuzdeDiv.textContent.replace('%', '') ?? 0;
                            animateValue(yuzdeDiv, prev, `0%`, 1000);
                            return;
                        }
                        const votePercentage = Math.round((oylar[aday] / totalVotes) * 100);
                        let prev = yuzdeDiv.textContent.replace('%', '');
                        animateValue(yuzdeDiv, prev, `${votePercentage}%`, 1000);
                    });

                    const sandikElement = document.getElementById('acilan-sandik');
                    if (sandikElement) {
                        const updatedSandik = Math.round((totalVotes / sunucuUyeSayisi) * 100);
                        let prev = sandikElement.textContent.replace('%', '');
                        animateValue(sandikElement, prev, `${updatedSandik}%`, 1000);
                    }
                });
            last = 0;
        }

        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const range = parseInt(end) - parseInt(start);
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * range + parseInt(start));
                element.textContent = `${value}%`;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        function lastCheck() {
            last++;
            let ms = document.getElementById("ms");
            ms.textContent = last / 10 + " saniye";
        }

        function cokilebenibebegim() {
            document.cookie = "debug=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }

        updateData();

        setInterval(lastCheck, 100);
        setInterval(updateData, 1000);
        setInterval(updateKedi, 1000);
    </script>



</body>

</html>