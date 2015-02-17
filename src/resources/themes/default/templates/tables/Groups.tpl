{ table->groups->pages }
<table id="groups" class="taskTable">
    <thead>
    <tr>
        <th id="groupName" class="large">{ table->th->name }</th>
        <th id="groupAdmin" class="medium">{ table->th->admin }</th>
        <th id="groupAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->groups->content }</tbody>
</table>