<form id="list_form" class="trackrForm" method="post" action="lists.php?p=Trackr&amp;l=Main&amp;page=lists">
    <h3>Add List</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input id="name" name="name" type="text" placeholder="Name">
                <input id="author" name="author" type="hidden" value="{ form->content->user }">
                <label for="project">Project:</label>
                <select name="project" id="project">
                    { form->content->projects }
                </select><br />
                <label for="public">Public:</label>
                <select name="public" id="public">
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
                <label for="minimal">Minimal View:</label>
                <select name="minimal" id="minimal">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select><br />
                <label for="main">Main:</label>
                <select name="main" id="main">
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
                <button class="submit" onclick="switchPage(event, 'page_2', 'page_3'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_3">
            <fieldset id="inputs">
                <label for="guest-view">Guest View:</label>
                <select name="guest-view" id="guest-view">
                    <option value="0">No</option>
                    <option value="1" selected>Yes</option>
                </select><br />
                <label for="guest-edit">Guest Edit:</label>
                <select name="guest-edit" id="guest-edit">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select><br />
                <label for="view-permission">View Permission:</label>
                <select name="view-permission" id="view-permission">
                    <option value="none" selected>None</option>
                    { form->content->nodes }
                </select><br />
                <label for="edit-permission">Edit Permission:</label>
                <select name="edit-permission" id="edit-permission">
                    <option value="none" selected>None</option>
                    { form->content->nodes }
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_3', 'page_2'); return false;">Back</button>
                <input type="submit" class="submit" name="add-list" value="Add">
            </fieldset>
        </div>
    </div>
</form>