{ table->pages->languages }
<table id="languages" class="taskTable" style="padding-top:0";>
    <thead>
    <tr>
        <th id="languageShort" class="small">{ table->th->short }</th>
        <th id="languageIcon" class="small">{ table->th->icon }</th>
        <th id="languageName" class="large">{ table->th->name }</th>
        <th id="languageAuthor" class="medium">{ table->th->author }</th>
        <th id="languageVersion" class="medium">{ table->th->version }</th>
        <th id="languageAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->content->languages }</tbody>
</table>