<?php
/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2010-2015 Mike van Riel<mike@phpdoc.org>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Renderer;

use Mockery as m;
use phpDocumentor\Renderer\Template\Parameter;

/**
 * Tests the functionality for the Template class.
 */
class TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testNameIsRegisteredAndCanBeRetrieved()
    {
        $name = 'name';
        $fixture = new Template($name);

        $this->assertSame($name, $fixture->getName());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The name of a template should be a string, received: true
     */
    public function testInstantiatingATemplateFailsIfTheNameIsNotAString()
    {
        new Template(true);
    }

    public function testRegisteringAParameter()
    {
        $parameter1 = new Parameter('param1', 'value');
        $parameter2 = new Parameter('param2', 'value');

        $fixture = new Template('name', [$parameter1]);

        $this->assertSame([ 'param1' => $parameter1 ], $fixture->getParameters());

        $fixture->with($parameter2);

        $this->assertSame([ 'param1' => $parameter1, 'param2' => $parameter2 ], $fixture->getParameters());
    }

    public function testRegisteringAParameterWithTheSameNameOverwritesTheFirst()
    {
        $parameter1 = new Parameter('param1', 'value1');
        $parameter2 = new Parameter('param1', 'value2');

        $fixture = new Template('name', [$parameter1]);
        $fixture->with($parameter2);

        $this->assertNotSame([ 'param1' => $parameter1 ], $fixture->getParameters());
        $this->assertSame([ 'param1' => $parameter2 ], $fixture->getParameters());
    }

    public function testRegisteringAnActionToBeHandled()
    {
        $action1 = m::mock(Action::class);
        $action2 = m::mock(Action::class);

        $fixture = new Template('name', [], [ $action1 ]);

        $this->assertSame([ $action1 ], $fixture->getActions());

        $fixture->handles($action2);

        $this->assertSame([ $action1, $action2 ], $fixture->getActions());
    }
}
