<form id="label-form" class="trackrForm" method="post" action="list.php?p=Trackr&l=Main&page=labels">
    <h3>Edit Label</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input name="project" type="hidden" value="{ form->value->project }">
                <input name="list" type="hidden" value="{ form->value->list }">
                <input name="labelname" type="text" placeholder="Label Name" value="{ form->value->label }">
                <label for="textcolor">Text Color: </label>
                <label id="labelcolor-text" onclick="linkColorField(event, 'labelcolor-text', 'textcolor'); return false;"></label>
                <input type="hidden" name="textcolor" value="{ form->value->text }"><br /><label for="backgroundcolor">Background Color: </label>
                <label id="labelcolor-background" onclick="linkColorField(event, 'labelcolor-background', 'backgroundcolor'); return false;"></label>
                <input type="hidden" name="backgroundcolor" value="{ form->value->background }"><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="edit-label" value="Edit">
            </fieldset>
        </div>
    </div>
</form>