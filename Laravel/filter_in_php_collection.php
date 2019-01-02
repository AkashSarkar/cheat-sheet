<?php
$collection->filter(function ($item) use ($external_parameter) {
    return $item->hash_id === $external_parameter->operands;
});