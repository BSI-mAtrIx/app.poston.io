<?php

$query ='SELECT * FROM `nvx_addons`
                    where name = "n_generator"';
$query .= ' LIMIT 1';

$sth = $this->n_pdo->prepare($query);

$sth->execute();

$xdata = $sth->fetchAll(PDO::FETCH_ASSOC);

if (!isset($xdata[0])){
    $return_cg_code = 'empty';
}

$return_cg_code = $xdata[0]['code'];