<?php
function flash_message($message, $error)
{
    if ($_SESSION["flash_message"] === $error) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' .
            $message
            . '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
