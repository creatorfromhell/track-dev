{ table->pages->activities }
<table id="activities" class="taskTable">
    <thead>
    <tr>
        <th id="activityDescription" class="large">{ table->th->activity }</th>
        <th id="activityArchived" class="small">{ table->th->archived }</th>
        <th id="activityDate" class="medium">{ table->th->logged }</th>
        <th id="activityAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->content->activities }</tbody>
</table>