<div class="modal-body">
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <input type="text" class="form-control" id="taskName" name="task" placeholder="Nom tache" <?= isset($task) ? 'value="'.$task['name_task'].'"' : "" ?> required>
            </div>
            <div class="form-group">
                <textarea class="form-control" id="taskContent" name="content" placeholder="Description" required><?= isset($task) ? $task['content_task'] : "" ?></textarea>
            </div>
            <div class="form-group">
                <input type="datetime-local" class="form-control" id="taskDate" name="date" <?= isset($task) ? 'value='.$task['start_task'] : "" ?> required>
            </div>
            <div class="form-group">
                <select name="category" class="form-control" id="categoryName" <?= isset($task) ? 'value='.$task['category_task'] : "" ?>>
                    <?= $categories ?>
                </select>
            </div>
            <?php if(isset($task)) : ?> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <input type="hidden" name="id_task" value="<?= isset($task) ? $task['id_task'] : "" ?>">
                    <input type="submit" name="submitEdit" class="btn btn-primary" value="Enregistrer les modifications">
                </div>
            <?php else : ?>
                <input type="submit" name="submitTask" class="btn btn-success" value="Ajouter">
            <?php endif; ?>
        </div>
    </form>

</div>
