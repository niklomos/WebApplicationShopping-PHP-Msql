<?php 
function generatePagination($current_page, $total_pages, $search_input = null, $search = null) {
    $pagination_html = '<nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item ' . (($current_page == 1) ? 'disabled' : '') . '">
                <a class="page-link" href="?';
    if (!empty($search_input)) {
        $pagination_html .= 'search_input=' . urlencode($search_input) . '&';
    }
    if (!empty($search)) {
        $pagination_html .= 'search&';
    }
    $pagination_html .= 'page=1" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-angles-left"></i></a>
            </li>
            <li class="page-item ' . (($current_page == 1) ? 'disabled' : '') . '">
                <a class="page-link" href="?';
    if (!empty($search_input)) {
        $pagination_html .= 'search_input=' . urlencode($search_input) . '&';
    }
    if (!empty($search)) {
        $pagination_html .= 'search&';
    }
    $pagination_html .= 'page=' . (($current_page > 1) ? ($current_page - 1) : 1) . '" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-angle-left"></i></a>
            </li>';
    
    for ($i = 1; $i <= $total_pages; $i++) {
        $pagination_html .= '<li class="page-item ' . (($current_page == $i) ? 'active' : '') . '">';
        $pagination_html .= '<a class="page-link" href="?';
        if (!empty($search_input)) {
            $pagination_html .= 'search_input=' . urlencode($search_input) . '&';
        }
        if (!empty($search)) {
            $pagination_html .= 'search&';
        }
        $pagination_html .= 'page=' . $i . '">' . $i . '</a>';
        $pagination_html .= '</li>';
    }

    $pagination_html .= '<li class="page-item ' . (($current_page == $total_pages) ? 'disabled' : '') . '">
                <a class="page-link" href="?';
    if (!empty($search_input)) {
        $pagination_html .= 'search_input=' . urlencode($search_input) . '&';
    }
    if (!empty($search)) {
        $pagination_html .= 'search&';
    }
    $pagination_html .= 'page=' . (($current_page < $total_pages) ? ($current_page + 1) : $total_pages) . '"><i class="fa-solid fa-angle-right"></i></a>
            </li>
            <li class="page-item ' . (($current_page == $total_pages) ? 'disabled' : '') . '">
                <a class="page-link" href="?';
    if (!empty($search_input)) {
        $pagination_html .= 'search_input=' . urlencode($search_input) . '&';
    }
    if (!empty($search)) {
        $pagination_html .= 'search&';
    }
    $pagination_html .= 'page=' . $total_pages . '"><i class="fa-solid fa-angles-right"></i></a>
            </li>
        </ul>
    </nav>';

    return $pagination_html;
}
?>

?>