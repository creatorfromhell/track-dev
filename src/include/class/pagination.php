<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/12/14
 * Time: 11:34 PM
 * Version: Beta 1
 * Last Modified: 8/12/14 at 11:34 PM
 * Last Modified by Daniel Vidmar.
 */

/**
 * Class Pagination
 */
class Pagination {

    /**
     * @var string
     */
    public $returnValue = "?";

    /**
     * @var string
     */
    public $extraQuery = "";

    /**
     * @var int
     */
    public $startingValue = 0;

    /**
     * @var int
     */
    public $items = 10;

    /**
     * @var float|int
     */
    public $page = 1;

    /**
     * @var float
     */
    public $totalPages = 1.0;

    /**
     * @var string
     */
    public $columnString = "*";

    /**
     * @var string
     */
    public $table = "";

    /**
     * @var string
     */
    public $pageString = "";

    /**
     * @param $t
     * @param $c
     * @param $p
     * @param int $i
     * @param string $r
     * @param string $extra
     */
    function __construct($t, $c, $p, $i = 10, $r = "?", $extra = "") {
        $this->table = $t;
        $this->columnString = $c;
        $this->page = $p;
        $this->items = $i;
        $this->returnValue = $r;
        $this->extraQuery = $extra;
        $this->prepareValues();
		if($this->page > $this->totalPages) {
			$this->page = $this->totalPages;
			$this->prepareValues();
		}
        $this->buildPageString();
    }

    /**
     *
     */
    public function paginate() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT ".$this->columnString." FROM `".$this->table."` ".$this->extraQuery." LIMIT ".$this->startingValue.", ".$this->items);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $out = "";
            $out .= "<tr>";
            $columns = explode(", ", $this->columnString);
            foreach($columns as &$column) {
                $out .= "<td>".$row[$column]."</td>";
            }
            $out .= "</tr>";
            echo $out;
        }
    }

    /**
     * @return array
     */
    public function paginateReturn() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT ".$this->columnString." FROM `".$this->table."` ".$this->extraQuery." LIMIT ".$this->startingValue.", ".$this->items);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     *
     */
    public function prepareValues() {
        global $pdo;

        $stmt1 = $pdo->prepare("SELECT Count(*) FROM `".$this->table."`");
        $stmt1->execute();
        $count = intval($stmt1->fetchColumn());

        $this->startingValue = (($this->page - 1) * $this->items);
        $this->totalPages = ceil($count / $this->items);
    }

    /**
     *
     */
    public function buildPageString() {
        $this->pageString = "";
        $this->pageString .= "<div id='pages'>";
        $this->pageString .= "<strong><a href='".$this->returnValue."pn=1'>First</a></strong>";
        for($i = 1; $i <= $this->totalPages; $i++) {
            $active = ($i == $this->page) ? "class='active'" : "";
            $this->pageString .= "<a ".$active." href='".$this->returnValue."pn=".$i."'>".$i."</a>";
        }
        $this->pageString .= "<strong><a href='".$this->returnValue."pn=".$this->totalPages."'>Last</a></strong>";
        $this->pageString .= "</div>";
    }
}