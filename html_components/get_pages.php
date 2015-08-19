<?php
// smet();
$pages = $db->findBySql("SELECT * FROM pages WHERE parent_id IS NULL OR parent_id = 0 ORDER BY position"); // parent pages only
$reqUri = preg_replace("/^\/nvdFramework\//", "", $_SERVER['REQUEST_URI']);
$currentPageTitle = $db->gfv("title", "pages", "url LIKE '%" . $reqUri . "%'");
// pr($pages);
//prser();
// prlq();
if (!$currentPageTitle) {
// ** The following determines on which page we currently are:
// $_SERVER['PHP_SELF'] gives (e.g.): '/ses/index.php'
// preg_match() expects any no. of characters (except whitespace or /) between '/' and '.'
    preg_match("/\/[^ \t\r\n\/]*\./", $_SERVER['PHP_SELF'], $matches);
// $matches[0]: /index.
// So we remove / and . by substr()
    $requested_Page = substr($matches[0], 1, -1); // returns file name like index, users
// if page_id is supplied in query string
    if (isset($_GET['page_id'])) {
        $currentPageTitle = $db->gfv("title", "pages", "id=" . $_GET['page_id']);
    } // else find from pages using the $current_Page
    elseif ($currentPageTitle = $db->gfv("title", "pages", "url LIKE '%" . $requested_Page . "%'")) {
    } // The last option..
    else {
        $currentPageTitle = ucfirst($requested_Page);
    }
}
// the page we're on:
$curPage = new Pag();
$curPage = Pag::findOneByCondition("title='" . $currentPageTitle . "'");
if ($curPage) {
    $curPage->name = strtolower(str_replace(" ", "_", $currentPageTitle));
}
// shet();

?>