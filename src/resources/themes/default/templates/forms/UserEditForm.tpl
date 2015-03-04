<form method="post" action="admin.php?t=users">
    <h3>Edit User</h3>
    <div id="form-holder">
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input name="id" type="hidden" value="{ form->value->id }">
                <input id="username" name="username" type="text" value="{ form->value->name }" placeholder="Username">
                <input id="email" name="email" type="text" value="{ form->value->email }" placeholder="User Email">
                <input id="password" name="password" type="password" placeholder="User Password">
                <input id="c_password" name="c_password" type="password" placeholder="Confirm Password">
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2" class="form-page">
            <fieldset id="inputs">
                <label for="group">Group: </label>
                <select name="group" id="group">
                    { form->value->group }
                </select><br />
                <div class="pick-field">
                    <div class="title">Permissions</div>
                    <div class="column-titles">
                        <label class="left">Available</label>
                        <label class="right">Added</label>
                        <div class="clear"></div>
                    </div>
                    <div id="permissions-available" class="column-left" ondrop="onDrop(event, 'permissions-value', 'remove')" ondragover="onDragOver(event)">
                        { form->value->permissions }
                    </div>
                    <div id="permissions-added" class="column-right" ondrop="onDrop(event, 'permissions-value', 'add')" ondragover="onDragOver(event)">
                        { form->value->permissions_used }
                    </div>
                    <input id="permissions-value" name="permissions-value" type="hidden" value="{ form->value->permission_values }">
                </div>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="edit-user" value="Edit">
            </fieldset>
        </div>
    </div>
</form>