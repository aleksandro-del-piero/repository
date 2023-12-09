<?php


namespace AleksandroDelPiero\Repository\Contracts;


interface Repository
{
    /**
     * Get model class
     * @return string
     */
    public function getModel():string;
}
