<?php
$pattern = '/(.*)\.(.*)/';
$ret = preg_match($pattern, '14.5p', $matches);

echo intval($matches[1]);