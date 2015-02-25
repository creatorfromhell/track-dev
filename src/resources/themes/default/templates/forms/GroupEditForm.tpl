<form class="trackrForm" method="post" action="admin.php?t=groups">
    <h3>Add Group</h3>
    <div id="form-holder">
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input id="name" name="name" type="text" placeholder="Name">
                <label for="admin">Admin: </label>
                <select name="admin" id="admin">
                    { form->content->admin }
                </select><br />
                <label for="preset">Preset: </label>
                <select name="preset" id="preset">
                    { form->content->preset }
                </select>
            </fieldset>
            <fieldset id="links">
                <button class="submit" onclick="switchPage(event, 'page_1', 'page_2'); return false;">Next</button>
            </fieldset>
        </div>
        <div id="page_2" class="form-page">
            <fieldset id="inputs">
                <div class="pick-field">
                    <div class="title">Permissions</div>
                    <div class="column-titles">
                        <label class="left">Available</label>
                        <label class="right">Added</label>
                        <div class="clear"></div>
                    </div>
                    <div id="permissions-available" class="column-left" ondrop="onDrop(event, 'permissions-value', 'remove')" ondragover="onDragOver(event)">
                        { form->content->nodes }
                    </div>
                    <div id="permissions-added" class="column-right" ondrop="onDrop(event, 'permissions-value', 'add')" ondragover="onDragOver(event)">
                        { form->content->added_nodes }
                    </div>
                    <input id="permissions-value" name="permissions-value" type="hidden" value="">
                </div>
            </fieldset>
            <fieldset id="links">
                <button class="submit_2" onclick="switchPage(event, 'page_2', 'page_1'); return false;">Back</button>
                <input type="submit" class="submit" name="add_group" value="Add">
            </fieldset>
        </div>
    </div>
</form>