<form method="post" action="admin.php?t=permissions">
    <h3>Edit Node</h3>
    <div id="form-holder">
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="node" name="node" type="text" placeholder="Node" value="{ form->value->name }">
                <textarea id="description" name="description" ROWS="3" COLS="40">{ form->value->description }</textarea>
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="edit-permission" value="Edit">
            </fieldset>
        </div>
    </div>
</form>