<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Log\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Log\Business\Model\LogListener\LogListenerInterface;
use Symfony\Component\Process\Process;

/**
 * @method \Spryker\Zed\Log\Communication\LogCommunicationFactory getFactory()
 * @method \Spryker\Zed\Log\LogConfig getConfig()
 * @method \Spryker\Zed\Log\Business\LogFacadeInterface getFacade()
 */
class FilebeatLogListenerPlugin extends AbstractPlugin implements LogListenerInterface
{
    public function startListener(): void
    {
        $process = new Process(['sudo service filebeat start']);
        $process->run();
    }

    public function stopListener(): void
    {
        $process = new Process(['sudo service filebeat stop']);
        $process->run();
    }
}
