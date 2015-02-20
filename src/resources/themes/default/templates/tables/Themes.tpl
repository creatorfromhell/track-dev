{ table->pages->themes }
<table id="themes" class="taskTable"style="padding-top:0";>
    <thead>
    <tr>
        <th id="themeName" class="large">{ table->th->name }</th>
        <th id="themeAuthor" class="medium">{ table->th->author }</th>
        <th id="themeVersion" class="medium">{ table->th->version }</th>
        <th id="themeAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->content->themes }</tbody>
</table>