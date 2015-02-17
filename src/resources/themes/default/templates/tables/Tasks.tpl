{ table->tasks->pages }
<table id="list" class="taskTable">
    <thead>
    <tr>
        <th id="taskID" class="small">#</th>
        <th id="taskTitle" class="large">{ table->th->name }</th>
        <!-- minimal start -->
        <th id="taskAssignee" class="medium">{ table->th->assignee }</th>
        <th id="taskCreated" class="medium">{ table->th->created }</th>
        <th id="taskAuthor" class="medium">{ table->th->author }</th>
        <!-- minimal end -->
        <th id="taskAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->tasks->content }</tbody>
</table>