<?php
namespace App\Calendar;

class Month {

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    private $month;
    private $year;

    /**
     * Month constructor
     * @param int $month : le mois compris entre 1 et 12
     * @param int $year : l'année
     * @throws Exception
     */
    
    public function __construct(?int $month = null, ?int $year = null){
        if($month === null){
            $month = intval(date('m'));
        }
        if($year === null){
            $year = intval(date('Y'));
        }
        if($month < 1 || $month > 12){
            throw new \Exception("Le mois $month n'est pas valide.");
        }
        if($year < 1970){
            throw new \Exception("L'année est inférieure à 1970");
        }
        $this->setMonth($month);
        $this->setYear($year);
    }

    public function getMonths(): array {
        return $this->months;
    }

    public function getMonth(): int {
        return $this->month;
    }

    public function setMonth(int $month): void {
        $this->month = $month;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }

    /**
     * Retourne le mois en toutes lettres
     * @return string
     */
    public function toString(): string {
        return $this->getMonths()[$this->getMonth() -1] . ' ' . $this->getYear();
    }

    /**
     * Renvoie le nombre de semaines dans le mois
     * @return int
     */
    public function getWeeks() {
        $start = $this->getStartingDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) +1;
        if($weeks < 0){
            $weeks = intval($start->format('W'));
        }else{
            return $weeks;
        }
    }

    /**
     * Est-ce que le jour est dans le mois en cours
     * @return bool
     */
    public function withinMonth(\Datetime $date): bool {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Return first day of month
     * @return \Datetime
     */
    public function getStartingDay(): \Datetime {
        return new \Datetime("{$this->getYear()}-{$this->getMonth()}-01");

    }

    /**
     * Renvoie le mois suivant
     * @return Month
     */
    public function nextMonth(): Month {
        $month = $this->getMonth() + 1;
        $year = $this->getYear();
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoie le mois précédent
     * @return Month
     */
    public function previousMonth(): Month {
        $month = $this->getMonth() - 1;
        $year = $this->getYear();
        if($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}