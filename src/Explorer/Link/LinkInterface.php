<?php
namespace Aeq\Hal\Explorer\Link;

use Aeq\Hal\Explorer\DataGettableInterface;

interface LinkInterface extends DataGettableInterface
{
    /**
     * @param array $variables
     * @param array $options
     * @return DataGettableInterface
     */
    public function follow(array $variables = [], array $options = []);
}
