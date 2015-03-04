<form id="label-form" class="trackrForm" method="post" action="list.php?p=Trackr&l=Main&page=labels">
    <h3>Add Label</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="project" type="hidden" value="{ form->content->project }">
                <input name="list" type="hidden" value="{ form->content->list }">
                <input name="name" type="text" placeholder="Label Name">
                <label for="color">Text Color: </label>
                <label id="color-text" onclick="linkColorField(event, 'color-text', 'color'); return false;"></label>
                <input type="hidden" name="color" value="#000000"><br />
                <label for="background">Background Color: </label>
                <label id="color-background" onclick="linkColorField(event, 'color-background', 'background'); return false;"></label>
                <input type="hidden" name="background" value="#000000"><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="add-label" value="Add">
            </fieldset>
        </div>
    </div>
</form>