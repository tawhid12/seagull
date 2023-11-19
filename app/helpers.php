<?php 

function title_case($value)
{
    return mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
}




