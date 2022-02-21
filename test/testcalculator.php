<!DOCTYPE html>
<html>
<title>calculate</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <style>
        .bb, .bb::before, .bb::after {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0; }

        .bb {
            width: 200px;
            height: 200px;
            margin: auto;
/*
            background: url("//blog.codepen.io/wp-content/uploads/2012/06/Button-White-Large.png") no-repeat 50%/70% rgba(0, 0, 0, 0.1);
*/
            color: #69ca62;
            -webkit-box-shadow: inset 0 0 0 1px rgba(105, 202, 98, 0.5);
            box-shadow: inset 0 0 0 1px rgba(105, 202, 98, 0.5); }
        .bb::before, .bb::after {
            content: '';
            z-index: -1;
            margin: -5%;
            -webkit-box-shadow: inset 0 0 0 2px;
            box-shadow: inset 0 0 0 2px;
            -webkit-animation: clipMe 8s linear infinite;
            animation: clipMe 8s linear infinite; }
        .bb::before {
            -webkit-animation-delay: -4s;
            animation-delay: -4s; }

        @-webkit-keyframes clipMe {
            0%, 100% {
                clip: rect(0px, 220px, 2px, 0px); }
            25% {
                clip: rect(0px, 2px, 220px, 0px); }
            50% {
                clip: rect(218px, 220px, 220px, 0px); }
            75% {
                clip: rect(0px, 220px, 220px, 218px); } }

        @keyframes clipMe {
            0%, 100% {
                clip: rect(0px, 220px, 2px, 0px); }
            25% {
                clip: rect(0px, 2px, 220px, 0px); }
            50% {
                clip: rect(218px, 220px, 220px, 0px); }
            75% {
                clip: rect(0px, 220px, 220px, 218px); } }

        html,
        body {
            height: 100%; }

        body {
            position: relative;
            background-color: #0f222b; }

    </style>
</head>
<body>
    <div class="bb"></div>
</body>
</html>
<script>
    function generateMoney(){
        var money,result;
        money=Number(document.formcalculate.money.value);
        result=Math.trunc(money-(money*0.01));
        document.formcalculate.generatemoney.value=result;
    }
</script>