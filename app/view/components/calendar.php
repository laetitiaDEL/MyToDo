<?php 

require "../app/Calendar/Month.php"; 
require "../app/Calendar/Tasks.php";
$month = new App\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$tasks = new App\Calendar\Tasks();

$firstday = $month->getStartingDay();
$firstday = $firstday->format('N') === '1' ? $firstday : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = (clone $firstday)->modify('+'. (6 + 7 * ($weeks - 1)) . ' days');
$tasks = $tasks->getTasksBetweenByDay($firstday, $end);

?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h4><?= $month->toString()?></h4>
    <div>
        <a class="btn btn-primary btn-sm" href="<?= url('/task') ?>?month=<?= $month->previousMonth()->getMonth() ?>&year=<?= $month->previousMonth()->getYear() ?>">&lt</a>
        <a class="btn btn-primary btn-sm" href="<?= url('/task') ?>?month=<?= $month->nextMonth()->getMonth() ?>&year=<?= $month->nextMonth()->getYear() ?>">&gt</a>
    </div>
</div>

<div class="calendar-container flex-grow-1" style="min-height: 0; overflow: hidden;">
    <table class="calendar-table calendar-table-<?= $weeks ?>weeks">
    <?php for($i=0; $i< $weeks; $i++): ?>
        <tr>
            <?php 
            foreach($month->days as $k=>$day):
                $date = (clone $firstday)->modify("+" . $k + $i*7 . "days");
                $tasksForDay = $tasks[$date->format('Y-m-d')] ?? [];
            ?>
                
            <td class="<?= $month->withinMonth($date)? '' :'calendar-othermonth'?>">
                <div class="calendar-day-container">
                    <?php if($i === 0): ?>
                    <div class="calendar-weekday">
                        <?= substr($day,0,3) ?>
                    </div>
                    <?php endif; ?>
                    <div class="calendar-day"><?= $date->format('d') ?></div>
                    <?php foreach($tasksForDay as $task): ?>
                        <div class="calendar-task">
                            <a href="<?= url('/taskEdit') ?>?id_task=<?= $task['id_task'] ?>" 
                            class="btn btn-outline-info btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#updateModal<?= $task['id_task'] ?>">
                            <?= (new \DateTime($task['start_task']))->format('H:i') ?> - <?= $task['name_task'] ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </td>
                
            <?php endforeach; ?>
        </tr>
        <?php endfor; ?>
    </table>
</div>

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