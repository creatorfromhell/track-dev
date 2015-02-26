<form id="label-form" class="trackrForm" method="post" action="list.php?p=Trackr&l=Main&page=labels">
    <h3>Add Label</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="project" type="hidden" value="{ form->content->project }">
                <input name="list" type="hidden" value="{ form->content->list }">
                <input name="labelname" type="text" placeholder="Label Name">
                <label for="textcolor">Text Color: </label>
                <label id="labelcolor-text" onclick="linkColorField(event, 'labelcolor-text', 'textcolor'); return false;"></label>
                <input type="hidden" name="textcolor" value="#000000"><br /><label for="backgroundcolor">Background Color: </label>
                <label id="labelcolor-background" onclick="linkColorField(event, 'labelcolor-background', 'backgroundcolor'); return false;"></label>
                <input type="hidden" name="backgroundcolor" value="#000000"><br />
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="add-label" value="Add">
            </fieldset>
        </div>
    </div>
</form>