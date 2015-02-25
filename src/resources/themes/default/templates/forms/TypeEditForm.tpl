<form id="version-type-form" class="trackrForm" method="post" action="projects.php?p=Trackr&amp;l=Main&amp;page=types">
    <h3>Add Version Type</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input id="type-name" name="type-name" type="text" placeholder="Name">
                <textarea id="type-description" name="type-description" ROWS="3" COLS="40"></textarea>
                <label for="type-stable">Stable:</label>
                <select name="type-stable" id="type-stable">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="add-version-type" value="Add">
            </fieldset>
        </div>
    </div>
</form>