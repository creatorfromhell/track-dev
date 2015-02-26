<div id="calendarHolder">
    <h3>
        <a title="Previous Year" href="{ pages->overview->back_year }">&lt;&lt;</a>&nbsp;&nbsp;
        <a title="Previous Month" href="{ pages->overview->back_month }">&lt;</a>&nbsp;&nbsp;
        { pages->overview->h3 }&nbsp;&nbsp;
        <a title="Next Month" href="{ pages->overview->forward_month }">&gt;</a>&nbsp;&nbsp;
        <a title="Next Year" href="{ pages->overview->forward_year }">&gt;&gt;</a>&nbsp;&nbsp;
    </h3>
    <table id="calendar">
        <thead>
        <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </tr>
        </thead>
        <tbody>
        { pages->overview->dates }
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function showDate(day) {
        window.location = { pages->overview->show_date } + day;
    }
</script>