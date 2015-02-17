<div class="content">
    <!-- title, description, author, assignee, due, created, finished, versionname, labels, editable, taskstatus, progress -->
    <h3><label class="fmleft"><a href="{ pages->task->back }" style="text-shadow:none;">Back</a></label>{ pages->task->title }<label class="fmright"><label class="status { pages->task->status->class }">{ pages->task->status->name }</label></label></h3>
    <div title="{ pages->task->progress }" class="progress"><div class="progress-bar" style="width:{ pages->task->progress }"></div></div>
    <div class="task-info">
        <div class="task-column fmleft">
            <label class="task-author">Author: <a href="#">{ pages->task->author }</a></label>
            <label class="task-created">Created: { pages->task->created }</label>
            <label class="task-assignee">Assignee: <a href="#">{ pages->task->assignee }</a></label>
        </div>
        <div class="task-column fmright">
            <label class="task-version">Version: <a href="#">{ pages->task->version }</a></label>
            <label class="task-due">Due Date: { pages->task->due }</label>
            <label class="task-finish">Completion Date: { pages->task->finished }</label>
        </div>
    </div>
    <div class="clear"></div>
    <pre class="task-description word-wrap"><label class="task-description-title">Description: </label><br />{ pages->task->description }</pre>
    <div class="labels">{ pages->task->labels }</div>
    <div class="clear"></div>
</div>
<!--<div class="below-content">
    <h3>Task Comments</h3>
</div>-->