{ table->types->pages }
<table id="version-types" class="taskTable">
    <thead>
    <tr>
        <th id="typeName" class="large">{ table->th->name }</th>
        <th id="typeDescription" class="medium">{ table->th->description }</th>
        <th id="typeStable" class="small">{ table->th->stable }</th>
        <th id="typeAction" class="action">{ table->th->actions }</th>
    </tr>
    </thead>
    <tbody>{ table->types->content }</tbody>
</table>