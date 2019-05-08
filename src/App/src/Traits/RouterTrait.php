<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 2019-05-08
 * Time: 14:15
 */

declare(strict_types=1);

namespace App\Traits;

use Zend\Expressive\Router\RouterInterface;

trait RouterTrait
{
    /** @var RouterInterface */
    private $router;

    /**
     * @param RouterInterface $router
     *
     * @return $this
     */
    public function setRouter(RouterInterface $router): self
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }
}
