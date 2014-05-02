<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/8/14
 * Time: 7:30 PM
 * Version: Beta 1
 * Last Modified: 4/8/14 at 7:30 PM
 * Last Modified by Daniel Vidmar.
 */
?>
<div id="tasks_chart" class="module">
    <h4>Tasks Chart</h4>
    <div id="chart_key">
        <div class="entry"><label style="background-color:rgba(25,25,112,0.5);border:1px solid rgba(25,25,112,1);" class="entry_colour"></label>Created</div>
        <div class="entry"><label style="background-color:rgba(0,100,0,0.5);border:1px solid rgba(0,100,0,1);" class="entry_colour"></label>Finished</div>
    </div>
    <canvas id="chart_tasks" class="module" onmouseover="showKey('tasks_chart');" onmouseout="hideKey('tasks_chart');" width="380" height="380"></canvas>
</div>
<div id="assigned_users" class="module">
    <h4>Top Assigned Users</h4>
    <div id="chart_key">
        <div class="entry"><label style="background-color:rgba(25,25,112,0.5);border:1px solid rgba(25,25,112,1);" class="entry_colour"></label>Created</div>
        <div class="entry"><label style="background-color:rgba(0,100,0,0.5);border:1px solid rgba(0,100,0,1);" class="entry_colour"></label>Finished</div>
    </div>
    <canvas id="chart_assigned" class="module" onmouseover="showKey('assigned_users');" onmouseout="hideKey('assigned_users');" width="380" height="380"></canvas>
</div>
<div class="module">
    <h4>Latest Tasks</h4>
    <?php
        $latestTasks = ProjectFunc::latestTasks($project);
        foreach($latestTasks as &$task) {
            echo '<div class="task"><a href="#">'.$formatter->replace($task).'</a></div>';
        }
    ?>
</div>
<script type="text/javascript">
    //Chart Data
    var chartTasksData = {
        labels : [<?php echo ProjectFunc::getTasksChartData($project, true, false); ?>],
        datasets : [
            {
                fillColor : "rgba(25,25,112,0.5)",
                strokeColor : "rgba(25,25,112,1)",
                pointColor : "rgba(25,25,112,1)",
                pointStrokeColor : "#fff",
                data : [<?php echo ProjectFunc::getTasksChartData($project, false, false); ?>]
            },
            {
                fillColor : "rgba(0,100,0,0.5)",
                strokeColor : "rgba(0,100,0,1)",
                pointColor : "rgba(0,100,0,1)",
                pointStrokeColor : "#fff",
                data : [<?php echo ProjectFunc::getTasksChartData($project, false, true); ?>]
            }
        ]
    }

    var chartAssignedData = {
        labels : ["creatorfromhell","Bob","Jim","Jill","Mary"],
        datasets : [
            {
                fillColor : "rgba(25,25,112,0.5)",
                strokeColor : "rgba(25,25,112,1)",
                data : [100,5,50,10,70]
            },
            {
                fillColor : "rgba(0,100,0,0.5)",
                strokeColor : "rgba(0,100,0,1)",
                data : [76,5,20,9,55]
            }
        ]
    }

    //Chart Options

    //Chart Variables
    var tasksContext = document.getElementById("chart_tasks").getContext("2d");
    var chartTasks = new Chart(tasksContext).Line(chartTasksData);

    var assignedContext = document.getElementById("chart_assigned").getContext("2d");
    var chartAssigned = new Chart(assignedContext).Bar(chartAssignedData);
</script>