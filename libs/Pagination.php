<?php

// This is a helper class to make paginating 
// records easy.
class Pagination {
	
  public $current_page;
  public $per_page;
  public $total_count;

  public function __construct($page=1, $per_page=30, $total_count=0){
  	$this->current_page = (int)$page;
    $this->per_page = (int)$per_page;
    $this->total_count = (int)$total_count;
  }

    function prepSql($sql){
        global $db;
        // 1. set the total count of pagination class*************************
        // prepare sql for counting results

        $newSql = preg_replace("/^SELECT.*FROM/", "SELECT COUNT(*) FROM", $sql);
        // find the count
        $result = $db->findBySql($newSql);
        // set value
        $this->total_count = $result[0]["COUNT(*)"];

        // 2. check to see if the user changed the results per page option
        if( isset( $_POST['res_per_page'] ) ){
            $this->per_page = $_SESSION['res_per_page'] = $_POST['res_per_page'];
        }
        elseif( isset( $_SESSION['res_per_page'] ) ){
            $this->per_page = $_SESSION['res_per_page'];
        }
        // 3. find only the required results
        $this->updateCurrentPage();
        $sql .= " LIMIT ".$this->per_page." OFFSET ".$this->offset();
        return $sql;
    }

    function updateCurrentPage(){
        if( isset( $_GET['currentPage'] ) ){
            $this->current_page = $_GET['currentPage'];
        }
    }

  public function offset() {
    return ($this->current_page - 1) * $this->per_page;
  }

  public function total_pages() {
    return ceil($this->total_count/$this->per_page);
	}
	
  public function previous_page() {
    return $this->current_page - 1;
  }
  
  public function next_page() {
    return $this->current_page + 1;
  }

	public function has_previous_page() {
		return $this->previous_page() >= 1 ? true : false;
	}

	public function has_next_page() {
		return $this->next_page() <= $this->total_pages() ? true : false;
	}


}

$pagination = new Pagination();

?>