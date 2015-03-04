<form id="version-type-form" class="trackrForm" method="post" action="projects.php?p=Trackr&amp;l=Main&amp;page=types">
    <h3>Add Version Type</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input id="name" name="name" type="text" placeholder="Name">
                <textarea id="description" name="description" ROWS="3" COLS="40"></textarea>
                <label for="stable">Stable:</label>
                <select name="stable" id="stable">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="add-type" value="Add">
            </fieldset>
        </div>
    </div>
</form>