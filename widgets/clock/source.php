<div id="widget-space">
    <center><h3 id="widget-clock-time">00:00:00</h3><span id="widget-clock-date">lundi 1er janvier 2000</span></center>
</div>
<script>

setInterval(() => {
    time = new Date()
    hours = time.getHours()
    minutes = time.getMinutes()
    seconds = time.getSeconds()
    day = time.getDate()
    month = time.getMonth() + 1
    year = time.getFullYear()
    dow = time.getDay() + 1
    if (hours < 10) {
        hours_str = "0" + hours
    } else {
        hours_str = hours
    }
    if (minutes < 10) {
        minutes_str = "0" + minutes
    } else {
        minutes_str = minutes
    }
    if (seconds < 10) {
        seconds_str = "0" + seconds
    } else {
        seconds_str = seconds
    }
    if (day == 1) {
        day_str = "1er"
    } else {
        day_str = day
    }
    if (dow == 2) {
        dow_str = "lundi"
    }
    if (dow == 3) {
        dow_str = "mardi"
    }
    if (dow == 4) {
        dow_str = "mercredi"
    }
    if (dow == 5) {
        dow_str = "jeudi"
    }
    if (dow == 6) {
        dow_str = "vendredi"
    }
    if (dow == 7) {
        dow_str = "samedi"
    }
    if (dow == 1) {
        dow_str = "dimanche"
    }
    if (month == 1) {
        month_str = "janvier"
    }
    if (month == 2) {
        month_str = "février"
    }
    if (month == 3) {
        month_str = "mars"
    }
    if (month == 4) {
        month_str = "avril"
    }
    if (month == 5) {
        month_str = "mai"
    }
    if (month == 6) {
        month_str = "juin"
    }
    if (month == 7) {
        month_str = "juillet"
    }
    if (month == 8) {
        month_str = "août"
    }
    if (month == 9) {
        month_str = "septembre"
    }
    if (month == 10) {
        month_str = "octobre"
    }
    if (month == 11) {
        month_str = "novembre"
    }
    if (month == 12) {
        month_str = "décembre"
    }
    document.getElementById('widget-clock-time').innerHTML = hours_str + ":" + minutes_str + ":" + seconds_str
    document.getElementById('widget-clock-date').innerHTML = dow_str + " " + day_str + " " + month_str + " " + year
}, 100)

</script>