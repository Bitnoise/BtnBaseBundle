<?php

namespace Btn\BaseBundle\Assetic\Factory\Worker;

use Assetic\Asset\AssetInterface;
use Assetic\Factory\AssetFactory;
use Assetic\Factory\Worker\WorkerInterface;

class UnuseControllerWorker implements WorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(AssetInterface $asset, AssetFactory $factory)
    {
        $asset->setTargetPath(str_replace('_controller/', '', $asset->getTargetPath()));

        return $asset;
    }
}
