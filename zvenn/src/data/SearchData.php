<?php
namespace App\data;

use App\Entity\Type;


class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var array
     */
    public $Type = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;
}