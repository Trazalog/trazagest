
<!DOCTYPE html>
<html >
<head>




    <link href="Kendo/styles/kendo.common.min.css" rel="stylesheet">
    <link href="Kendo/styles/kendo.default.min.css" rel="stylesheet">


    <script src="Kendo/js/jquery.min.js"></script>
    <script src="Kendo/js/kendo.web.min.js"></script>
    <script src="Kendo/examples/content/shared/js/console.js"></script>
    <script src="Kendo/src/js/cultures/kendo.culture.es-AR.js"></script>

</head>
<body>
<div id="example" class="k-content">
    <div id="background">
        <div id="calendar"></div>
    </div>
    <script>
        $(document).ready(function() {
            // create Calendar from div HTML element
            $("#calendar").kendoCalendar();
        });
    </script>
    <style scoped>
        #background {
            width: 254px;
            height: 250px;
            margin: 30px auto;
            padding: 69px 0 0 11px;
            background: url('Kendo/examples/content/web/calendar/calendar.png') transparent no-repeat 0 0;
        }
        #calendar {
            width: 241px;
        }
    </style>


    <input id="datepicker" />

    <script>
        $(document).ready(function() {
            $("#datepicker").kendoDatePicker()
                .closest(".k-widget")
                .attr("id", "datepicker_wrapper")
                .culture("es-AR");


            var datepicker = $("#datepicker").data("kendoDatePicker");

            var setValue = function () {
                datepicker.value($("#value").val());
            };

            $("#enable").click(function() {
                datepicker.enable();
            });

            $("#disable").click(function() {
                datepicker.enable(false);
            });

            $("#open").click(function() {
                datepicker.open();
            });

            $("#close").click(function() {
                datepicker.close();
            });

            $("#value").kendoDatePicker({
                change: setValue
            });

            $("#set").click(setValue);

            $("#get").click(function() {
                alert(datepicker.value());
            });
        });
    </script>
</div>


</body>
</html>