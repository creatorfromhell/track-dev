<form id="label-form" class="trackrForm" method="post" action="list.php?p=Trackr&l=Main&page=labels">
    <h3>Edit Label</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input name="project" type="hidden" value="{ form->value->project }">
                <input name="list" type="hidden" value="{ form->value->list }">
                <input name="name" type="text" placeholder="Label Name" value="{ form->value->label }">
                <label for="color">Text Color: </label>
                <label id="color-text" onclick="linkColorField(event, 'color-text', 'color'); return false;"></label>
                <input type="hidden" name="color" value="{ form->value->text }"><br /><label for="background">Background Color: </label>
                <label id="color-background" onclick="linkColorField(event, 'color-background', 'background'); return false;"></label>
                <input type="hidden" name="background" value="{ form->value->background }"><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="edit-label" value="Edit">
            </fieldset>
        </div>
    </div>
</form>