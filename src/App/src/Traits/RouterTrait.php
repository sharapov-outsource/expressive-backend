<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-05-08
 *     Time: 14:15
 */

namespace App\Traits;

use Mezzio\Router\RouterInterface;

trait RouterTrait
{
    /** @var RouterInterface */
    private $router;

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return $this
     */
    public function setRouter(RouterInterface $router) : self
    {
        $this->router = $router;
        return $this;
    }
}
