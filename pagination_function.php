<?php 
// ฟังก์ชันสำหรับสร้าง Pagination
function generatePagination($current_page, $total_pages, $search_input = null) {
    $pagination_html = '<nav aria-label="Page navigation" class="pb-3">
        <ul class="pagination justify-content-center p-0 m-0 ">';

    // First page
    $pagination_html .= '<li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">';
    $pagination_html .= '<a class="page-link" href="' . ($search_input ? '?search_input=' . urlencode($search_input) . '&page=1' : '?page=1') . '" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-angles-left"></i></a>';
    $pagination_html .= '</li>';

    // Previous page
    $pagination_html .= '<li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">';
    $pagination_html .= '<a class="page-link" href="' . ($search_input ? '?search_input=' . urlencode($search_input) . '&page=' . ($current_page - 1) : '?page=' . ($current_page - 1)) . '" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-angle-left"></i></a>';
    $pagination_html .= '</li>';

    // Page numbers
    for ($page = 1; $page <= $total_pages; $page++) {
        $pagination_html .= '<li class="page-item ' . ($page == $current_page ? 'active' : '') . '">';
        $pagination_html .= '<a class="page-link" href="' . ($search_input ? '?search_input=' . urlencode($search_input) . '&page=' . $page : '?page=' . $page) . '">' . $page . '</a>';
        $pagination_html .= '</li>';
    }

    // Next page
    $pagination_html .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">';
    $pagination_html .= '<a class="page-link" href="' . ($search_input ? '?search_input=' . urlencode($search_input) . '&page=' . ($current_page + 1) : '?page=' . ($current_page + 1)) . '"><i class="fa-solid fa-angle-right"></i></a>';
    $pagination_html .= '</li>';

    // Last page
    $pagination_html .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">';
    $pagination_html .= '<a class="page-link" href="' . ($search_input ? '?search_input=' . urlencode($search_input) . '&page=' . $total_pages : '?page=' . $total_pages) . '"><i class="fa-solid fa-angles-right"></i></a>';
    $pagination_html .= '</li>';

    $pagination_html .= '</ul></nav>';

    return $pagination_html;
}

?>