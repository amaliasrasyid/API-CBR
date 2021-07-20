<?php
function removeHtmlTags($string){
    $decodeToTagHtml = html_entity_decode($string);
    return strip_tags($decodeToTagHtml);
}