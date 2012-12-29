<?php

class Pagination {

	public $current_page;
	public $per_page;
	public $total_count;
	
	public function __construct($page=1, $per_page=20, $total_count=0) {
		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;
	}
	
	public function offset() {
		return $this->per_page * ($this->current_page - 1);
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
	
	public function paginationNav ($urlFormat, $lang = false)
	{
	    $firstPage = $lang ? "First Page" : "الصفحة الاولى";
	    $lastPage = $lang ? "Last Page" : "الصفحة الاخيرة";
	    $nextPage = $lang ? "Next" : "التالي";
	    $previousPage = $lang ? "Previous" : "السابق";
	
	    $output = '<div id="pagination">';
	    if ($this->total_pages() > 1) {
	
	        if ($this->page != 1) {
	            $output .= "<a href=\"$urlFormat/page=1";
	            $output .= "\">&laquo; $firstPage</a>   ";
	        }
	
	        if ($this->has_previous_page()) {
	            $output .= "<a href=\"$urlFormat/page=";
	            $output .= $this->previous_page();
	            $output .= "\">&laquo; $previousPage</a>   ";
	        }
	
	        for ($i = 1; $i <= $this->total_pages(); $i ++) {
	            if ($i == $this->page) {
	                $output .= " <a href=\"$urlFormat/page={$i}\" class=\"current\">{$i}</a> ";
	
	            } else {
	                $output .= " <a href=\"$urlFormat/page={$i}\">{$i}</a> ";
	
	            }
	        }
	
	        if ($this->has_next_page()) {
	            $output .= "<a href=\"$urlFormat/page=";
	            $output .= $this->next_page();
	            $output .= "\">$nextPage &raquo;</a>  ";
	        }
	
	        if ($this->page != $this->total_pages()) {
	            $output .= "<a href=\"$urlFormat/page=";
	            $output .= $this->total_pages();
	            $output .= "\">$lastPage &raquo;</a>  ";
	        }
	    }
	    $output .= '</div>';
	    return $output;
	}
}

?>