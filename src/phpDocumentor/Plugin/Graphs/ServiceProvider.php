<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.4
 *
 * @copyright 2010-2014 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Plugin\Graphs;

use Cilex\Application;
use Cilex\ServiceProviderInterface;
use phpDocumentor\Plugin\Graphs\Writer\Graph;
use phpDocumentor\Transformer\Writer\Collection;

class ServiceProvider implements ServiceProviderInterface
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Registers services on the given app.
     *
     * @param Application $app An Application instance.
     */
    public function register(Application $app)
    {
        /** @var Collection $writerCollection */
        $writerCollection = $this->container->get(Collection::class);
        $writerCollection['Graph'] = $this->container->get(Graph::class);
    }
}
