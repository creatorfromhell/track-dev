<form id="project-form" class="trackrForm" method="post" action="projects.php?p=Trackr&amp;l=Main&amp;page=projects">
    <h3>Edit Project</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="name" name="name" type="text" placeholder="Name" value="{ form->value->name }">
                <label for="public">Public:</label><select name="public" id="public">
                    { form->value->public }
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2">
            <fieldset id="inputs">
                <label for="preset">Preset:</label>
                <select name="preset" id="preset">
                    { form->value->preset }
                </select><br />
                <label for="main">Main List:</label>
                <select name="main" id="main">
                    { form->value->main }
                </select><br />
                <label for="overseer">Overseer:</label>
                <select name="overseer" id="overseer">
                    { form->value->overseer }
                </select>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="edit-project" value="Edit">
            </fieldset>
        </div>
    </div>
</form>