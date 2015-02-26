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
$first_week_day = date('w', $date);
$last_week_day = date('w', mktime(0, 0, 0, date('n', $date), date('t', $date), $year));
$back_year = "?p=".$project."&t=calendar&year=".($year - 1)."&month=".$month;
$back_month = "?p=".$project."&t=calendar&year=".$year."&month=".($month - 1);
$forward_year = "?p=".$project."&t=calendar&year=".($year + 1)."&month=".$month;
$forward_month = "?p=".$project."&t=calendar&year=".$year."&month=".($month + 1);
$show_date = '"?back='.$year.','.$month.'&t=calendarview&year='.$year.'&month='.$month.'&day="';

if($_GET['t'] == "calendarview") {
    $back = "#";
    if(isset($_GET['back'])) {
        $split = explode(',', $_GET['back']);
        $back = '<a href="?p='.$project.'&t=calendar&year='.$split[0].'&month='.$split[1].'" style="float:left;padding-left:10px;">Back</a>';
    }

    $month_date = mktime(0, 0, 0, $month, 1, $year);
    $day = (isset($_GET['day'])) ? $_GET['day'] : 1;
    $view_date = ProjectFunc::get_correct_date($year, $month, $day);
    $year = date('Y', $view_date);
    $month = date('n', $view_date);
    $day = date('j', $view_date);

    $back_year = "?p=".$project."&t=calendarview&year=".($year - 1)."&month=".$month."&day=".$day;
    $back_month = "?p=".$project."&t=calendarview&year=".$year."&month=".($month - 1)."&day=".$day;
    $back_day = "?p=".$project."&t=calendarview&year=".$year."&month=".$month."&day=".($day - 1);
    $forward_year = "?p=".$project."&t=calendarview&year=".($year + 1)."&month=".$month."&day=".$day;
    $forward_month = "?p=".$project."&t=calendarview&year=".$year."&month=".($month + 1)."&day=".$day;
    $forward_day = "?p=".$project."&t=calendarview&year=".$year."&month=".$month."&day=".($day + 1);
    $h3 = $back.date('l M jS Y', $view_date);

    $rules['pages']['overview']['back_year'] = $back_year;
    $rules['pages']['overview']['back_month'] = $back_month;
    $rules['pages']['overview']['back_day'] = $back_day;
    $rules['pages']['overview']['forward_day'] = $forward_day;
    $rules['pages']['overview']['forward_month'] = $forward_month;
    $rules['pages']['overview']['forward_year'] = $forward_year;
    $rules['pages']['overview']['h3'] = $h3;
    $rules['pages']['overview']['events'] = ProjectFunc::get_events($project, $year, $month, $day);
    $rules['pages']['overview']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "pages/overview/CalendarView.tpl").'}';
} else {
    $h3 = date('F', $date)." - ".$year;
    $dates = '';
    $total = 1;
    for($d = 1; $d <= date('t', $date); $d++){
        if(($total % 7) - 1 == 0) { $dates .= "<tr>"; }
        if($d == 1 && $first_week_day > 0) {
            $new_year = ($month - 1 == 0) ? $year-- : $year;
            $last_day = date('j', strtotime('last day of previous month', $date));
            for($o = $last_day - ($first_week_day - 1); $o <= $last_day; $o++) {
                $dates .= '<th class="last"><label class="date">'.$o.'</label></th>';
                $total++;
            }
        }
        $class = ($year == date('Y') && $month == date('n')) ? ($d <= date('d')) ? ($d < date('d')) ? 'class="old"' : 'class="today"' : '' : '';
        if(ProjectFunc::has_event($project, $year, $month, $d)) { $class='class="marked" onclick="showDate('.$d.');"'; }
        $dates .= '<th '.$class.'><label class="date">'.$d.'</label></th>';
        if($d == date('t', $date) && $last_week_day < 6) {
            $new_year = ($month + 1 == 13) ? $year++ : $year;
            $first_day = date('j', strtotime('first day of next month', $date));
            for($o = $first_day; $o <= $first_day + (6 - ($last_week_day + 1)); $o++) {
                $dates .= '<th class="last"><label class="date">'.$o.'</label></th>';
                $total++;
            }
        }
        if($total % 7 == 0) { echo "</tr>"; }
        $total++;
    }
    $rules['pages']['overview']['back_year'] = $back_year;
    $rules['pages']['overview']['back_month'] = $back_month;
    $rules['pages']['overview']['forward_month'] = $forward_month;
    $rules['pages']['overview']['forward_year'] = $forward_year;
    $rules['pages']['overview']['h3'] = $h3;
    $rules['pages']['overview']['dates'] = $dates;
    $rules['pages']['overview']['show_date'] = $show_date;
    $rules['pages']['overview']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "pages/overview/Calendar.tpl").'}';
}
?>