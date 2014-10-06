<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/8/14
 * Time: 7:31 PM
 * Version: Beta 1
 * Last Modified: 4/8/14 at 7:31 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<?php
$year = date('Y');
$month = date('n');

if(isset($_GET['month'])) {
    if($_GET['month'] >= 0 && $_GET['month'] <= 13) {
        $m = $_GET['month'];
        if($m == 13) { $m = 1; $year++; }
        if($m == 0) { $m = 12; $year--; }
        $month = $m;
    }
}

if(isset($_GET['year'])) {
    if($_GET['year'] > 0) {
        $year = $_GET['year'];
    }
}

$date = mktime(0, 0, 0, $month, 1, $year);
$firstWeekDay = date('w', $date);
$lastWeekDay = date('w', mktime(0, 0, 0, date('n', $date), date('t', $date), $year));
$backYear = "?p=".$project."&t=calendar&year=".($year - 1)."&month=".$month;
$backMonth = "?p=".$project."&t=calendar&year=".$year."&month=".($month - 1);
$forwardYear = "?p=".$project."&t=calendar&year=".($year + 1)."&month=".$month;
$forwardMonth = "?p=".$project."&t=calendar&year=".$year."&month=".($month + 1);
?>
<script type="text/javascript">
    function showDate(day) {
        window.location = "?back=<?php echo $year.','.$month; ?>&t=calendarview&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=" + day;
    }
</script>
<?php if($_GET['t'] == "calendar") { ?>
<div id="calendarHolder">
    <h3><a title="Previous Year" href="<?php echo $backYear; ?>">&lt;&lt;</a>&nbsp;&nbsp;<a title="Previous Month" href="<?php echo $backMonth; ?>">&lt;</a>&nbsp;&nbsp;<?php echo date('F', $date)." - ".$year; ?>&nbsp;&nbsp;<a title="Next Month" href="<?php echo $forwardMonth; ?>">&gt;</a>&nbsp;&nbsp;<a title="Next Year" href="<?php echo $forwardYear; ?>">&gt;&gt;</a></h3>
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
        <?php
        $total = 1;
        for($d = 1; $d <= date('t', $date); $d++){
            if(($total % 7) - 1 == 0) { echo "<tr>"; }
            if($d == 1 && $firstWeekDay > 0) {
                $newYear = ($month - 1 == 0) ? $year-- : $year;
                $lastDay = date('j', strtotime('last day of previous month', $date));
                for($o = $lastDay - ($firstWeekDay - 1); $o <= $lastDay; $o++) {
                    echo '<th class="last"><label class="date">'.$o.'</label></th>';
                    $total++;
                }
            }
            $class = ($year == date('Y') && $month == date('n')) ? ($d <= date('d')) ? ($d < date('d')) ? 'class="old"' : 'class="today"' : '' : '';
            if(ProjectFunc::hasEvent($project, $year, $month, $d)) { $class='class="marked" onclick="showDate('.$d.');"'; }
            echo '<th '.$class.'><label class="date">'.$d.'</label></th>';
            if($d == date('t', $date) && $lastWeekDay < 6) {
                $newYear = ($month + 1 == 13) ? $year++ : $year;
                $firstDay = date('j', strtotime('first day of next month', $date));
                for($o = $firstDay; $o <= $firstDay + (6 - ($lastWeekDay + 1)); $o++) {
                    echo '<th class="last"><label class="date">'.$o.'</label></th>';
                    $total++;
                }
            }
            if($total % 7 == 0) { echo "</tr>"; }
            $total++;
        }
        ?>
        </tbody>
    </table>
</div>
<?php } else {
    $back = "#";
    if(isset($_GET['back'])) {
        $split = explode(',', $_GET['back']);
        $back = '<a href="?p='.$project.'&t=calendar&year='.$split[0].'&month='.$split[1].'" style="float:left;padding-left:10px;">Back</a>';
    }
?>
    <div id="viewdate">
        <?php
            $monthDate = mktime(0, 0, 0, $month, 1, $year);
            $day = (isset($_GET['day'])) ? $_GET['day'] : 1;
            $viewDate = ProjectFunc::getCorrectDate($year, $month, $day);
            $year = date('Y', $viewDate);
            $month = date('n', $viewDate);
            $day = date('j', $viewDate);

            $backYear = "?p=".$project."&t=calendarview&year=".($year - 1)."&month=".$month."&day=".$day;
            $backMonth = "?p=".$project."&t=calendarview&year=".$year."&month=".($month - 1)."&day=".$day;
            $backDay = "?p=".$project."&t=calendarview&year=".$year."&month=".$month."&day=".($day - 1);
            $forwardYear = "?p=".$project."&t=calendarview&year=".($year + 1)."&month=".$month."&day=".$day;
            $forwardMonth = "?p=".$project."&t=calendarview&year=".$year."&month=".($month + 1)."&day=".$day;
            $forwardDay = "?p=".$project."&t=calendarview&year=".$year."&month=".$month."&day=".($day + 1);
        ?>
        <h3><?php echo $back; ?><?php echo date('l M jS Y', $viewDate); ?></h3>
        <?php echo ProjectFunc::getEvents($project, $year, $month, $day); ?>
        <h5><a title="Previous Year" href="<?php echo $backYear; ?>">&lt;&lt;&lt;</a>&nbsp;&nbsp;<a title="Previous Month" href="<?php echo $backMonth; ?>">&lt;&lt;</a>&nbsp;&nbsp;<a title="Previous Day" href="<?php echo $backDay; ?>">&lt;</a>&nbsp;&nbsp;<label style="font-weight:bolder;font-size:1.2em;">Navigation</label>&nbsp;&nbsp;<a title="Next Day" href="<?php echo $forwardDay; ?>">&gt;</a>&nbsp;&nbsp;<a title="Next Month" href="<?php echo $forwardMonth; ?>">&gt;&gt;</a>&nbsp;&nbsp;<a title="Next Year" href="<?php echo $forwardYear; ?>">&gt;&gt;&gt;</a></h5>
    </div>
<?php } ?>