<?php
?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,user-scalable=no">
    <link rel="icon" href="assets/img/favicon/cubic.webp" type="image/gif" sizes="16x16">
    <title>Cubic Ninja</title>
    <link rel="stylesheet" href="assets/new_css/cubic_ninja.css">
</head>
<body>
<!-- Game canvas -->
<canvas id="c"></canvas>

<!-- Gameplay HUD -->
<div class="hud">
    <div class="hud__score">
        <div class="score-lbl"></div>
        <div class="cube-count-lbl"></div>
    </div>
    <div class="pause-btn"><div></div></div>
    <div class="slowmo">
        <div class="slowmo__bar"></div>
    </div>

</div>

<!-- Menu System -->
<div class="menus">
    <div class="menu menu--main">
        <h1>მფრინავი კუბი</h1>
        <button type="button" class="play-normal-btn">თამაშის დაწყება</button>
      <!--  <button type="button" class="play-casual-btn">ვარჯიში</button>-->
    </div>
    <div class="menu menu--pause">
        <h1>მოლოდინის რეჟიმი</h1>
        <button type="button" class="resume-btn">თამაშის გაგრძელება</button>
        <button type="button" class="menu-btn--pause">მთავარი მენიუ</button>
    </div>
    <div class="menu menu--score">
        <h1>თამაში დამთავრდა</h1>
        <h2>შენი ქულა:</h2>
        <div class="final-score-lbl"></div>
        <div class="high-score-lbl"></div>
        <button type="button" class="play-again-btn">კვლავ სცადეთ</button>
        <button type="button" class="menu-btn--score">მთავარი მენიუ</button>
    </div>
</div>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="assets/new_js/cubic_ninja.js"></script>