{ table->version->pages }
<table id="versions" class="taskTable">
    <thead>
    <tr>
        <th id="versionName" class="large">{ table->th->name }</th>
        <th id="versionType" class="medium">{ table->th->type }</th>
        <th id="versionStable" class="small">{ table->th->stable }</th>
        <th id="versionAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->version->content }</tbody>
</table>