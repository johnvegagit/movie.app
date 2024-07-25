<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

/** show user message /inputs error/ **/
function show_err_msg()
{
    # If any signup error exist. save it in session and show to the user.
    if (isset($_SESSION['error_msg'])) {
        $errors = $_SESSION['error_msg'];

        foreach ($errors as $error) {
            echo '<span class="span-msg msg-dng">' . $error . '</span>';
        }

        unset($_SESSION['error_msg']);
    }
}

function show_inf_msg()
{
    # If any signup error exist. save it in session and show to the user.
    if (isset($_SESSION['info_msg'])) {
        $info_msgs = $_SESSION['info_msg'];

        foreach ($info_msgs as $info_msg) {
            echo '<span class="span-msg msg-inf">' . $info_msg . '</span>';
        }

        unset($_SESSION['info_msg']);
    }
}

function show_scs_msg()
{
    # If any signup error exist. save it in session and show to the user.
    if (isset($_SESSION['scss_msg'])) {
        $scss_msgs = $_SESSION['scss_msg'];

        foreach ($scss_msgs as $scss_msg) {
            echo '<span class="span-msg msg-scs">' . $scss_msg . '</span>';
        }

        unset($_SESSION['scss_msg']);
    }
}

function show_header_msg()
{
    # If any signup error exist. save it in session and show to the user.
    if (isset($_SESSION['header_scs_msg'])) {
        $client_msgs = $_SESSION['header_scs_msg'];

        foreach ($client_msgs as $client_msg) {
            echo '<span class="h-span-msg h-msg-scs">' . $client_msg . '</span>';
        }

        unset($_SESSION['header_scs_msg']);

    } elseif (isset($_SESSION['header_err_msg'])) {

        $client_msgs = $_SESSION['header_err_msg'];

        foreach ($client_msgs as $client_msg) {
            echo '<span class="h-span-msg h-msg-dng">' . $client_msg . '</span>';
        }

        unset($_SESSION['header_err_msg']);
    }
}

function showPre($txt)
{
    echo '<pre>';
    print_r($txt);
    echo '</pre>';
}