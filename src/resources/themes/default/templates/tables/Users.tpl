{ table->pages->users }
<table id="users" class="taskTable">
    <thead>
    <tr>
        <th id="userName" class="large">{ table->th->name }</th>
        <th id="userEmail" class="medium">{ table->th->email }</th>
        <th id="userGroup" class="medium">{ table->th->group }</th>
        <th id="userRegister" class="medium">{ table->th->registered }</th>
        <th id="userAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->content->users }</tbody>
</table>