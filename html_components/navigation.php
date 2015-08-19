<section class='container hidden-print' id='navigation'>
    <nav class="navigation">
        <ul class="nav nav-pills">
            <?php
            foreach ($pages as $page) {
                if ($page['show_in_nav'] == 'Yes' || $user->isDevlepor()) {
                    $query_string = $page['url'] == 'records.php' ? "?page_id=" . $page['id'] : "";
                    $active = $page['title'] == $currentPageTitle ? "class='active'" : "";
                    $id = strtolower(str_replace(" ", "_", $page['title']));
                    // get child pages
                    $child_pages = $db->findBySql("SELECT * FROM pages WHERE parent_id = " . $page['id'] . " ORDER BY position,title");
                    $clas = $child_pages ? "class='dropdown'" : "";
                    $link_dropdown_attribs = $child_pages ? 'class="dropdown-toggle" data-toggle="dropdown"' : '';
                    $caret = $child_pages ? '<span class="caret"></span>' : '';
                    echo "<li id='" . $id . "' " . $active . " " . $clas . ">";
                    echo "<a href='" . $page['url'] . $query_string . "' " . $link_dropdown_attribs . ">" . $page['title'] . " " . $caret . "</a>";
                    if ($child_pages) {
                        echo "<ul class='dropdown-menu' role='menu' aria-labelledby='" . $id . "'>";
                        foreach ($child_pages as $key => $ch_page) {
                            if ($ch_page['show_in_nav'] == 'Yes' || $user->isDevlepor()) {
                                $query_string = $ch_page['url'] == 'records.php' ? "?page_id=" . $ch_page['id'] : "";
                                $active = $ch_page['title'] == $currentPageTitle ? "class='active'" : "";
                                $ch_id = strtolower(str_replace(" ", "_", $ch_page['title']));
                                echo "<li id='" . $ch_id . "' " . $active . ">";
                                echo "<a href='" . $ch_page['url'] . $query_string . "' tabindex='-1'>" . $ch_page['title'] . "</a>";
                                echo "</li>";
                            }
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </nav>
</section>
