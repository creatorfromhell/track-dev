{ table->projects->pages }
<table id="projects" class="taskTable">
    <thead>
    <tr>
        <th id="projectName" class="large">{ table->th->name }</th>
        <th id="projectCreated" class="medium">{ table->th->created }</th>
        <th id="projectCreator" class="medium">{ table->th->creator }</th>
        <th id="projectOverseer" class="medium">{ table->th->overseer }</th>
        <th id="projectAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->projects->content }</tbody>
</table>