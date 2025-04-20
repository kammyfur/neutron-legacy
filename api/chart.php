<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - DEMO-CHART/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - DEMO-CHART/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

?>

<html>
    <head>
      <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
      <style id="stylesheet" type="text/css">
        @import 'https://fonts.googleapis.com/css?family=Open+Sans';

html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
}

.chart--container {
  height: 450px;
  width: 100%;
  min-height: 150px;
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
		<div id="myChart" class="chart--container"><a class="zc-ref" href="https://www.zingchart.com/">Powered by ZingChart</a></div>
	</body>
</html>
    </body>
    <script>
      let chartConfig = {
  type: 'pie',
  plot: {
    tooltip: {
      text: '%npv%',
      padding: '5 10',
      fontSize: '18px'
    },
    valueBox: {
      text: '%t\n%npv%',
      placement: 'out'
    },
    borderColor: '#2B313B',
    borderWidth: '5px'
  },
  plotarea: {
    margin: '20 0 0 0'
  },
  source: {
    text: 'Certaines informations peuvent être inexactes',
    fontColor: '#8e99a9',
    fontFamily: 'Open Sans',
    textAlign: 'left'
  },
  series: [
    {
      text: 'IE and Edge',
      values: [4.8],
    },
    {
      text: 'Chrome',
      values: [63.69],
    },
    {
      text: 'Firefox',
      values: [4.64],
    },
    {
      text: 'Safari',
      values: [15.15],
    },
    {
      text: 'Other',
      values: [11.72],
    }
  ]
};

zingchart.render({
  id: 'myChart',
  data: chartConfig
});
    </script>
  </html>