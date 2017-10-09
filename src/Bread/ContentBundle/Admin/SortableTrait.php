<?php

namespace Bread\ContentBundle\Admin;

use Pix\SortableBehaviorBundle\Services\PositionHandler;

trait SortableTrait
{
    /**
     * @var PositionHandler
     */
    protected $positionService;

    /**
     * @param PositionHandler $positionHandler
     */
    public function setPositionService(PositionHandler $positionHandler)
    {
        $this->positionService = $positionHandler;
        $this->positionService->setPositionField(['default' => 'sortableRank']);
    }

    /**
     * @return PositionHandler
     */
    public function getPositionService()
    {
        return $this->positionService;
    }
}