<script>
    var zeroPad = function(num, pad) {
        var pd = Math.pow(10, pad);
        return Math.floor(num * pd) / pd;
    }

    function toHoursAndMinutes(totalSeconds) {
        // const totalMinutes = Math.floor(totalSeconds / 60);

        // const seconds = totalSeconds % 60;
        // const hours = Math.floor(totalMinutes / 60);
        // const minutes = totalMinutes % 60;

        // return hours + '<b>h</b> ' + minutes + '<b>m</b> ' + seconds + '<b>s</b>';
        var duration = totalSeconds * 1000;
        var days = Math.floor(duration / (1000 * 60 * 60 * 24));
        var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((duration % (1000 * 60)) / 1000);
        // Output the result in an element with id="demo"
        return days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    }

    function radiansToDegrees(radians) {
        return radians * (180 / Math.PI);
    }

    function st(starttime, endtime) {

        //this is correct way to get time gap between two dates
        var duration = (new Date(endtime)).getTime() - (new Date(starttime)).getTime();
        // console.log(starttime, endtime, distance);

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(duration / (1000 * 60 * 60 * 24));
        var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((duration % (1000 * 60)) / 1000);
        // Output the result in an element with id="demo"
        return days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        // var x = setInterval(function() {

        //     // Time calculations for days, hours, minutes and seconds
        //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //     // Output the result in an element with id="demo"
        //     document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
        //         minutes + "m " + seconds + "s ";
        //     //This line is added to decrease distance by 1 second
        //     distance -= 1000
        //     // If the count down is over, write some text
        //     if (distance < 0) {
        //         clearInterval(x);
        //         document.getElementById("demo").innerHTML = "EXPIRED";
        //     }
        // }, 1000);
    }

    function datetimeLocal(datetime) {
        const dt = new Date(datetime);
        dt.setMinutes(dt.getMinutes() - dt.getTimezoneOffset());
        return dt.toISOString().slice(0, 16);
    }

    function replacer(key, value) {
        if (typeof value === 'string') {
            //to avoid ///"
            //add space to , and :
            return value.replace(/"/g, '').replace(/,/g, ', ').replace(/:/g, ': ')
        } else {
            return value
        }
    }
</script>
