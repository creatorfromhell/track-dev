<form enctype="multipart/form-data" id="version-form" class="trackrForm" method="post" action="lists.php?p=Trackr&l=Main&page=versions">
    <h3>Add Version</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="project" type="hidden" value="{ form->content->project }">
                <input id="version-name" name="version-name" type="text" placeholder="Name">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="0" selected>None</option>
                    <option value="1">Upcoming</option>
                    <option value="2">Released</option>
                </select><br />
                <label for="version-type">Version Type:</label>
                <select name="version-type" id="version-type">
                    <option value="0" selected>None</option>
                    { form->content->types }
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2">
            <fieldset id="inputs">
                <label for="due-date">Due Date:</label>
                <input id="due-date" name="due-date" type="text" placeholder="YYYY-MM-DD" readonly>
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />Download: <input name="version_download" type="file" /><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="add-version" value="Add">
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