{ table->list->pages }
<table id="lists" class="taskTable">
    <thead>
    <tr>
        <th id="listName" class="large">{ table->th->name }</th>
        <th id="listCreated" class="medium">{ table->th->created }</th>
        <th id="listCreator" class="medium">{ table->th->creator }</th>
        <th id="listOverseer" class="medium">{ table->th->overseer }</th>
        <th id="listAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->list->content }</tbody>
</table>