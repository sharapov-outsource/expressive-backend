<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 29.12.2019
 *     Time: 23:49
 */

namespace App\Doctrine\Fixtures;

use App\Entity\Datascope as DatascopeEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Datascope implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist((new DatascopeEntity\DatascopeEntity())
            ->setDatascopeName(DatascopeEntity\DatascopeEntity::DATASCOPE_DEFAULT));
        $manager->flush();
    }
}
