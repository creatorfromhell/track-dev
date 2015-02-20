<div id="tasks_chart" class="module">
    <h4>Tasks Chart</h4>
    <div class="chart_key">
        <div class="entry"><label style="background-color:rgba(25,25,112,0.5);border:1px solid rgba(25,25,112,1);" class="entry_colour"></label>Created</div>
        <div class="entry"><label style="background-color:rgba(0,100,0,0.5);border:1px solid rgba(0,100,0,1);" class="entry_colour"></label>Finished</div>
    </div>
    <canvas id="chart_tasks" class="module" onmouseover="showKey('tasks_chart');" onmouseout="hideKey('tasks_chart');" width="380" height="380"></canvas>
</div>
<div id="assigned_users" class="module">
    <h4>Top Assigned Users</h4>
    <div class="chart_key">
        <div class="entry"><label style="background-color:rgba(25,25,112,0.5);border:1px solid rgba(25,25,112,1);" class="entry_colour"></label>Assigned</div>
        <div class="entry"><label style="background-color:rgba(0,100,0,0.5);border:1px solid rgba(0,100,0,1);" class="entry_colour"></label>Finished</div>
    </div>
    <canvas id="chart_assigned" class="module" onmouseover="showKey('assigned_users');" onmouseout="hideKey('assigned_users');" width="380" height="380"></canvas>
</div>
<div class="module">
    <h4>Latest Tasks</h4>
    { pages->overview->latest_tasks }
</div>
<script type="text/javascript">
    //Chart Data
    var chartTasksData = {
        labels : [{ pages->overview->tasks_chart->labels }],
        datasets : [
            {
                fillColor : "rgba(25,25,112,0.5)",
                strokeColor : "rgba(25,25,112,1)",
                pointColor : "rgba(25,25,112,1)",
                pointStrokeColor : "#fff",
                data : [{ pages->overview->tasks_chart->created }]
            },
            {
                fillColor : "rgba(0,100,0,0.5)",
                strokeColor : "rgba(0,100,0,1)",
                pointColor : "rgba(0,100,0,1)",
                pointStrokeColor : "#fff",
                data : [{ pages->overview->tasks_chart->completed }]
            }
        ]
    };

    var chartAssignedData = {
        labels : [{ pages->overview->assigned_chart->labels }],
        datasets : [
            {
                fillColor : "rgba(25,25,112,0.5)",
                strokeColor : "rgba(25,25,112,1)",
                data : [{ pages->overview->assigned_chart->created }]
            },
            {
                fillColor : "rgba(0,100,0,0.5)",
                strokeColor : "rgba(0,100,0,1)",
                data : [{ pages->overview->assigned_chart->completed }]
            }
        ]
    };

    //Chart Options

    //Chart Variables
    var tasksContext = document.getElementById("chart_tasks").getContext("2d");
    var chartTasks = new Chart(tasksContext).Line(chartTasksData);

    var assignedContext = document.getElementById("chart_assigned").getContext("2d");
    var chartAssigned = new Chart(assignedContext).Bar(chartAssignedData);
</script>