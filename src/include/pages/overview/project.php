<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/8/14
 * Time: 7:30 PM
 * Version: Beta 1
 * Last Modified: 4/8/14 at 7:30 PM
 * Last Modified by Daniel Vidmar.
 */
$latest_tasks_values = '';
$latest_tasks = ProjectFunc::latestTasks($project);
foreach($latest_tasks as &$task) {
    $latest_tasks_values .= '<div class="task"><a href="#">'.$formatter->replace($task).'</a></div>';
}
$rules['pages']['overview']['tasks_chart'] = array(
    'labels' => ProjectFunc::getTasksChartData($project, true, false),
    'created' => ProjectFunc::getTasksChartData($project, false, false),
    'completed' => ProjectFunc::getTasksChartData($project, false, true),
);
$rules['pages']['overview']['assigned_chart'] = array(
    'labels' => ProjectFunc::getAssignedUsersChartData($project, true, false),
    'created' => ProjectFunc::getAssignedUsersChartData($project, false, false),
    'completed' => ProjectFunc::getAssignedUsersChartData($project, false, true),
);
$rules['pages']['overview']['latest_tasks'] = $latest_tasks_values;
$rules['pages']['overview']['content'] = '{include->'.$theme_manager->GetTemplate((string)$theme->name, "pages/overview/Project.tpl").'}';