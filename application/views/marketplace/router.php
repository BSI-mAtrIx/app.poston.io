<?php
foreach (glob(FCPATH."application/views/marketplace/autoload/*.php") as $filename)
{
    include $filename;
}