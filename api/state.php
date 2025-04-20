<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - DEMO-STATEGRAPH/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - DEMO-STATEGRAPH/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

?>

<html>
    <head>
      <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
      <style id="stylesheet" type="text/css">
        html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
}

.chart--container {
  min-height: 150px;
  width: 100%;
  height: 100%;
}

.zc-ref {
  display: none;
}
      </style>
    </head>
    <body>
      <!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <title>ZingSoft Demo</title>
		<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
	</head>
	<body>
		<div id="myChart" class="chart--container">
			<a class="zc-ref" href="https://www.zingchart.com/">Powered by ZingChart</a>
		</div>
	</body>
</html>
    </body>
    <script>
    let feed = (callback) => {
        let tick = {};
        tick.plot0 = Math.round(Math.random() * 100);
        callback(JSON.stringify(tick));
    };

let chartConfig = {
  type: 'gauge',
  globals: {
    fontSize: '25px'
  },
  plot: {
    valueBox: {
      text: '%v%<br>...',
      fontSize: '35px',
      placement: 'center',
      rules: [
        {
          text: '%v%<br>Parfait',
          rule: '%v >= 80'
        },
        {
          text: '%v%<br>Bon',
          rule: '%v < 70 && %v >= 60'
        },
        {
          text: '%v%<br>Correct',
          rule: '%v < 60 && %v >= 50'
        },
        {
          text: '%v%<br>Mauvais',
          rule: '%v <  50'
        }
      ]
    },
    size: '100%'
  },
  plotarea: {
    marginTop: '80px'
  },
  scaleR: {
    aperture: 180,
    center: {
      visible: false
    },
    item: {
      offsetR: 0,
      rules: [
        {
          offsetX: '15px',
          rule: '%i == 9'
        }
      ]
    },
    labels: ['0%', '50%', '100%'],
    maxValue: 100,
    minValue: 0,
    ring: {
      rules: [
        {
          backgroundColor: '#E53935',
          rule: '%v == %v'
        },
      ],
      size: '50px'
    },
    step: 100,
    tick: {
      visible: true
    }
  },
  tooltip: {
    borderRadius: '5px'
  },
  refresh: {
    type: 'feed',
    url: 'feed()',
    interval: 500,
    resetTimeout: 1000,
    transport: 'js'
  },
  series: [
    {
      values: [0], // starting value
      backgroundColor: 'black',
      indicator: [10, 10, 10, 10, 0.75],
      animation: {
        effect: 'ANIMATION_EXPAND_VERTICAL',
        // method: 'ANIMATION_BACK_EASE_OUT',
        sequence: 'null',
        speed: 900
      }
    }
  ]
};

zingchart.render({
  id: 'myChart',
  data: chartConfig
});
    </script>
  </html>

<!DOCTYPE html>
<html>
	<head>
    <meta charset="utf-8">
    <title>ZingSoft Demo</title>
		<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
	</head>
	<body>
		<div id="myChart" class="chart--container">
		</div>
	</body>
</html>