<form id="task-form" class="trackrForm" method="post" action="list.php?p=Trackr&l=Main&page=tasks">
    <h3>Edit Task</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="title" name="title" type="text" placeholder="Title" value="{ form->value->title }">
                <textarea id="description" name="description" ROWS="3" COLS="40">{ form->value->description }</textarea>
                <input id="author" name="author" type="hidden" value="{ form->value->author }">
                <label for="assignee">Assignee:</label>
                <select name="assignee" id="assignee">
                    { form->value->assignee }
                </select><br />
                <label for="due-date">Due Date:</label>
                <input id="due-date" name="due-date" type="text" placeholder="0000-00-00" value="{ form->value->due }" readonly>
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2">
            <fieldset id="inputs">
                <label for="editable">Editable:</label>
                <select name="editable" id="editable">
                    { form->value->editable }
                </select><br />
                <label for="status">Status:</label>
                <select name="status" id="status">
                    { form->value->status }
                </select><br />
                <label for="version">Version:</label>
                <select name="version" id="version">
                    { form->value->version }
                </select><br />
                <label for="progress">Progress:<label id="progress_value">{ form->value->progress }</label></label><br />
                <input type="range" id="progress" name="progress" value="{ form->value->progress }" min="0" max="100" oninput="showValue('progress_value', this.value);">
            </fieldset>
            <fieldset id="links"><button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <button class="submit" onclick="switchPage(event, 'page_2', 'page_3'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_3">
            <fieldset id="inputs">
                <div class="pick-field">
                    <div class="title">Labels</div>
                    <div class="column-titles">
                        <label class="fmleft">Available</label>
                        <label class="fmright">Chosen</label>
                        <div class="clear"></div>
                    </div>
                    <div id="labels-available" class="column-left" ondrop="onDrop(event, 'labels', 'remove')" ondragover="onDragOver(event)" style="margin:0;">
                        { form->value->labels }
                    </div>
                    <div id="labels-chosen" class="column-right" ondrop="onDrop(event, 'labels', 'add')" ondragover="onDragOver(event)" style="margin:0;height:125px;max-height:125px;overflow-y:scroll;">
                        { form->value->labels_used }
                    </div>
                    <input id="labels-input" name="labels" type="hidden" value="{ form->value->label_values }">
                </div>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_3', 'page_2'); return false;">Back</button>
                <input type="submit" class="submit" name="edit-task" value="Edit">
            </fieldset>
        </div>
    </div>
</form>
<script>
    new datepickr('due-date', {
        fullCurrentMonth: true,
        dateFormat: 'Y-m-d',
        weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        suffix: { 1: 'st', 2: 'nd', 3: 'rd' },
        defaultSuffix: 'th'
    });
</script>