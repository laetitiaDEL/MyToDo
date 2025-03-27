<?php

namespace App\Calendar;

class Tasks {
    /**
     * Récupère toutes les taches commençant entre deux dates.
     * @param \Datetime $start
     * @param \Datetime $end
     * @return array
     */
    public function getTasksBetween(\Datetime $start, \Datetime $end): array {
        $pdo = DBconnect();
        $sql = "SELECT * FROM tasks WHERE id_user = ? AND start_task BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}'";
        $req = $pdo->prepare($sql);
        $req->bindParam(1, $_SESSION['id'],\PDO::PARAM_INT);
        $req->execute();
        $result = $req->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Récupère toutes les taches commençant entre deux dates, indéxé par jour
     * @param \Datetime $start
     * @param \Datetime $end
     * @return array
     */
    public function getTasksBetweenByDay(\Datetime $start, \Datetime $end): array {
        $tasks = $this->getTasksBetween($start, $end);
        $days = [];
        foreach($tasks as $task){
            $date = explode(' ',$task['start_task'])[0];
            if(!isset($days[$date])){
                $days[$date] = [$task];
            }else{
                $days[$date][0] = $task;
            }
        }
        return $days;
    }

}


?>