{ table->labels->pages }
<table id="label" class="taskTable">
    <thead>
    <tr>
        <th id="labelID" class="small">#</th>
        <th id="labelName" class="large">{ table->th->name }</th>
        <th id="taskAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->labels->content }</tbody>
</table>