<?php
/**
 * Created by Daniel Vidmar.
 * Date: 4/8/14
 * Time: 7:30 PM
 * Version: Beta 1
 * Last Modified: 4/8/14 at 7:30 PM
 * Last Modified by Daniel Vidmar.
 */
$latest_tasks_values = ' ';
$latest_tasks = ProjectFunc::latest_tasks($project);
foreach($latest_tasks as &$task) {
    $latest_tasks_values .= '<div class="task"><a href="#">'.$formatter->replace($task).'</a></div>';
}
$rules['pages']['overview']['tasks_chart'] = array(
    'labels' => ProjectFunc::get_tasks_chart_data($project, true, false),
    'created' => ProjectFunc::get_tasks_chart_data($project, false, false),
    'completed' => ProjectFunc::get_tasks_chart_data($project, false, true),
);
$rules['pages']['overview']['assigned_chart'] = array(
    'labels' => ProjectFunc::get_assigned_users_chart_data($project, true, false),
    'created' => ProjectFunc::get_assigned_users_chart_data($project, false, false),
    'completed' => ProjectFunc::get_assigned_users_chart_data($project, false, true),
);
$rules['pages']['overview']['latest_tasks'] = $latest_tasks_values;
$rules['pages']['overview']['content'] = '{include->'.$theme_manager->get_template((string)$theme->name, "pages/overview/Project.tpl").'}';