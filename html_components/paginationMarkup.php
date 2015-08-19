<?php
/**
 * Created by PhpStorm.
 * User: EngrNaveed
 * Date: 30-Dec-14
 * Time: 5:55 PM
 */
?>

<div id="paginationWraper" class="row hidden-print">
    <div class="col-sm-6">
        <ul class="pagination">
            <?php

            // previous link
            if ($pagination->has_previous_page()) {
                $arr = array("currentPage" => $pagination->previous_page());
                echo '<li><a href="' . appendToCurrentUri($arr) . '">&laquo;</a></li>';
            } else {
                echo "<li class='disabled'><a href='#'>&laquo;</a></li>";
            }
            // pages link
            for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                if ($i == $pagination->current_page) {
                    echo '<li class="active"><a href="#">' . $i . '</a></li>';
                } else {
                    $arr = array("currentPage" => $i);
                    echo '<li><a href="' . appendToCurrentUri($arr) . '">' . $i . '</a></li>';
                }
            }
            //next link
            if ($pagination->has_next_page()) {
                $arr = array("currentPage" => $pagination->next_page());
                echo '<li><a href="' . appendToCurrentUri($arr) . '">&raquo;</a></li>';
            } else {
                echo "<li class='disabled'><a href='#'>&raquo;</a></li>";
            }
            ?>
        </ul>
    </div>
    <?php
    // results per page selector
    echo "<div class='col-sm-3 pagination-info'>";
    echo "<form id='paginationForm' method='post'><p><label for='res_per_page'>Max. Results per Page: <input id='res_per_page' name='res_per_page' value='" . $pagination->per_page . "'></label></p></form>";
    echo "</div>";

    // show feedback about how many results are there and .....
    $resultStart = $pagination->offset() + 1;
    $resultEnd = $pagination->offset() + $pagination->per_page;
    if ($resultEnd > $pagination->total_count) {
        $resultEnd = $pagination->total_count;
    }
    if ($resultEnd == 0) {
        $resultStart = 0;
    }
    echo "<div class='col-sm-3 pagination-info'><p class=''>Showing Records " . $resultStart . " - " . $resultEnd . " of " . $pagination->total_count . "</p></div>";
    ?>
</div>