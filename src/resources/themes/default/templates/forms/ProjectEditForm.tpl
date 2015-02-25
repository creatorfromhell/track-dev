<form id="project-form" class="trackrForm" method="post" action="projects.php?p=Trackr&amp;l=Main&amp;page=projects">
    <h3>Add Project</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input id="name" name="name" type="text" placeholder="Name">
                <input id="author" name="author" type="hidden" value="{ form->content->user }">
                <label for="public">Public:</label><select name="public" id="public">
                    <option value="0">No</option>
                    <option value="1" selected>Yes</option>
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2">
            <fieldset id="inputs">
                <label for="mainproject">Main:</label>
                <select name="mainproject" id="mainproject">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select><br />
                <label for="overseer">Overseer:</label>
                <select name="overseer" id="overseer">
                    <option value="none" selected>None</option>
                    { form->content->users }
                </select>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="add-project" value="Add">
            </fieldset>
        </div>
    </div>
</form>