<form id="version-type-form" class="trackrForm" method="post" action="projects.php?p=Trackr&amp;l=Main&amp;page=types">
    <h3>Edit Version Type</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="type-name" name="type-name" type="text" placeholder="Name" value="{ form->value->name }">
                <textarea id="type-description" name="type-description" ROWS="3" COLS="40">
                    { form->value->description }
                </textarea>
                <label for="type-stable">Stable:</label>
                <select name="type-stable" id="type-stable">
                    { form->value->stability }
                </select><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="edit-version-type" value="Edit">
            </fieldset>
        </div>
    </div>
</form>