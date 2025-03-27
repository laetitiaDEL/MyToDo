<div class="card" id="<?= $task['id_task'] ?>">
  <div class="card-header">
    <?= $category[0]['name_category'] ?>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?= $task['name_task'] ?></h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">Date : <?= $task['start_task'] ?></h6>
    <p class="card-text"><?= $task['content_task'] ?></p>
    <a href="<?= url('/taskEdit') ?>?id_task=<?= $task['id_task'] ?>" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal<?= $task['id_task'] ?>">Modifier</a>

    <!-- Update modal -->
    <div class="modal fade" id="updateModal<?= $task['id_task'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Modifier la tache "<?= $task['name_task'] ?>"</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                  <?php include '../app/view/components/taskForm.php'; ?>

            </div>
        </div>
    </div>

    <!-- Formulaire de suppression -->
    <form action="" method="POST" style="display:inline;">
        <input type="hidden" name="id_task" value="<?= $task['id_task'] ?>">
        <input type="submit" name="submitDelete" class="btn btn-danger" value="Supprimer">
    </form>
  </div>
</div>