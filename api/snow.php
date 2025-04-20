<!-- START @export -->
<!-- Insert this tag in your HTML to enable the snow API and the 'snowapi-enable-snowfall' property -->

<style>

body, html {
    min-height: 100%;
    /* Only required if you don't have a Background : */
    background-image: url('/resources/image/config.jpg');
    background-size: cover;
    background-position: center;
    /* ------------------ */
}

div#snowapi-placeholder {
    overflow: hidden;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

[snowapi-enable-snowfall=""] {
    position: absolute;
    left: -100px;
    right: -100px;
    animation: SnowAPI_Wind 5s cubic-bezier(.56,.02,.47,1.01) infinite alternate;
    perspective: 100px;
}

[snowapi-enable-snowfall=""]::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: 2000px;
    background: url('snow-medium.png');
    animation: SnowAPI_Snowfall 10s linear infinite;
    transform: translateZ(50px);
}

@keyframes SnowAPI_Snowfall {
    from {
        transform: translateY(-1000px) translateZ(50px);
    }
}

@keyframes SnowAPI_Wind {
    to {
        transform: translateX(50px);
    }
}

</style>

<!-- END @export -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Snow Effect</title>
</head>
<body>
    <div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>
</body>
</html>