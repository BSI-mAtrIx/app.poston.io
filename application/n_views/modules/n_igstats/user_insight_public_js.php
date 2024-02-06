<script>
    $("document").ready(function () {

        var phoneCall = "<?php echo $phoneCall; ?>";
        var textMessage = "<?php echo $textMessage; ?>";
        var getDirections = "<?php echo $getDirections; ?>";
        var website = "<?php echo $website; ?>";
        var impressions = "<?php echo $impressions; ?>";
        var reach = "<?php echo $reach; ?>";
        var follower = "<?php echo $follower; ?>";
        var email_contacts = "<?php echo $email_contacts; ?>";
        var profile_views = "<?php echo $profile_views; ?>";

        var clicks_type_data = $('#clicks_type_data').val();

        var line = new Morris.Line({
            element: 'clicks_line_chart',
            resize: true,
            data: JSON.parse(clicks_type_data),
            xkey: 'date',
            ykeys: ['phone_call', 'text_message', 'get_directions', 'website', 'email_contacts'],
            labels: [phoneCall, textMessage, getDirections, website, email_contacts],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });


        // LINE CHART
        var impressions_data = $('#impressions_data').val();
        var line = new Morris.Line({
            element: 'impressions_line_chart',
            resize: true,
            data: JSON.parse(impressions_data),
            xkey: 'date',
            ykeys: ['impressions'],
            labels: [impressions],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });


        // LINE CHART
        var reach_data = $('#reach_data').val();
        //var profile_views = 'profile_views';
        var line = new Morris.Line({
            element: 'reach_chart',
            resize: true,
            data: JSON.parse(reach_data),
            xkey: 'date',
            ykeys: ['reach', 'profile_views'],
            labels: [reach, profile_views],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });

        // LINE CHART
        var follower_count_data = $('#follower_count_data').val();
        var line = new Morris.Area({
            element: 'follower_count_chart',
            resize: true,
            data: JSON.parse(follower_count_data),
            xkey: 'date',
            ykeys: ['follower_count'],
            labels: [follower],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });

        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 30, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,

            legend: {
                display: false
            }
        };

        //-------------
        //- PIE CHART -
        //-------------
        var reach_by_user_country_data = $("#reach_by_user_country_data").val();
        var pieChartCanvas = $("#reach_by_country_pieChart").get(0).getContext("2d");
        var PieData = JSON.parse(reach_by_user_country_data);

        var labels = PieData.map(function (e) {
            return e.label;
        });
        var data = PieData.map(function (e) {
            return e.value;
        });

        var colors = PieData.map(function (e) {
            return e.color;
        });

        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: colors
                }],
                labels: labels
            },
            options: pieOptions
        });


        //-----------------
        //- END PIE CHART -
        //-----------------

        //-------------
        //- PIE CHART -
        //-------------
        var reach_by_audience_locale_data = $("#reach_by_audience_locale_data").val();
        var pieChartCanvas = $("#reach_by_audience_locale_pieChart").get(0).getContext("2d");
        var PieData = JSON.parse(reach_by_audience_locale_data);
        var labels = PieData.map(function (e) {
            return e.label;
        });
        var data = PieData.map(function (e) {
            return e.value;
        });

        var colors = PieData.map(function (e) {
            return e.color;
        });

        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: colors
                }],
                labels: labels
            },
            options: pieOptions
        });


        //-----------------
        //- END PIE CHART -
        //-----------------

    });
</script>