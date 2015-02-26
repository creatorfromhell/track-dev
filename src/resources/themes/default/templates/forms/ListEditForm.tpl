<form id="list_form" class="trackrForm" method="post" action="lists.php?p=Trackr&l=Main&page=lists">
    <h3>Edit List</h3>
    <div id="holder">
        <div id="page_1">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="name" name="name" type="text" placeholder="Name" value="{ form->value->name }">
                <label for="project">Project:</label>
                <select name="project" id="project">
                    { form->value->project }
                </select><br />
                <label for="public">Public:</label>
                <select name="public" id="public">
                    { form->value->public }
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
                    { form->value->minimal }
                </select><br />
                <label for="mainlist">Main:</label>
                <select name="mainlist" id="mainlist">
                    { form->value->main }
                </select><br />
                <label for="overseer">Overseer:</label>
                <select name="overseer" id="overseer">
                    { form->value->overseer }
                </select>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <button class="submit" onclick="switchPage(event, 'page_2', 'page_3'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_3">
            <fieldset id="inputs">
                <label for="guestview">Guest View:</label>
                <select name="guestview" id="guestview">
                    { form->value->guest_view }
                </select><br />
                <label for="guestedit">Guest Edit:</label>
                <select name="guestedit" id="guestedit">
                    { form->value->guest_edit }
                </select><br />
                <label for="viewpermission">View Permission:</label>
                <select name="viewpermission" id="viewpermission">
                    { form->value->view_permission }
                </select><br />
                <label for="editpermission">Edit Permission:</label>
                <select name="editpermission" id="editpermission">
                    { form->value->edit_permission }
                </select><br />
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_3', 'page_2'); return false;">Back</button>
                <input type="submit" class="submit" name="edit-list" value="Edit">
            </fieldset>
        </div>
    </div>
</form>