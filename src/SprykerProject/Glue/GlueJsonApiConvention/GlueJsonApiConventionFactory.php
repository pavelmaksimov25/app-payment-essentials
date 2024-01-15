<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\GlueJsonApiConvention;

use AppPayment\Glue\GlueJsonApiConvention\Response\JsonGlueResponseFormatter;
use Spryker\Glue\GlueJsonApiConvention\GlueJsonApiConventionFactory as SprykerGlueJsonApiConventionFactory;
use Spryker\Glue\GlueJsonApiConvention\Response\JsonGlueResponseFormatterInterface;

class GlueJsonApiConventionFactory extends SprykerGlueJsonApiConventionFactory
{
    public function createJsonGlueResponseFormatter(): JsonGlueResponseFormatterInterface
    {
        return new JsonGlueResponseFormatter(
            $this->createJsonEncoder(),
            $this->getConfig(),
            $this->createResponseSparseFieldFormatter(),
        );
    }
}
