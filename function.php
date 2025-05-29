<?php

use support\Response;

/**
 * 报错html
 * @param int $status
 * @return Response
 */
function alone_error_html(int $status = 404): Response {
    return response("<html><head><title>$status Not Found</title></head><body><center><h1>$status Not Found</h1></center></body></html>");
}