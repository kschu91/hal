<?php
namespace Aeq\Hal\Explorer;

interface LinkInterface extends DataGettableInterface
{
    /**
     * @param array $variables
     * @param array $options
     * @return DataGettableInterface
     */
    public function follow(array $variables = [], array $options = []);
}
