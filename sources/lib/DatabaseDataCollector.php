<?php
/*
 * This file is part of Pomm's Silex™ ProfilerServiceProvider package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\Silex\ProfilerServiceProvider;

use Silex\Application;

use PommProject\Foundation\Pomm;
use PommProject\SymfonyBridge\DatabaseDataCollector as BaseDatabaseDataCollector;

/**
 * PommProfilerServiceProvider
 *
 * Silex ServiceProvider for Pomm profiler.
 *
 * @package PommProfilerServiceProvider
 * @copyright 2014 Grégoire HUBERT
 * @author Jérôme MACIAS
 * @author Grégoire HUBERT
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see ServiceProviderInterface
 */
class DatabaseDataCollector extends BaseDatabaseDataCollector
{

    public function renderExplain(Application $app, $idQuery)
    {
        if(!isset($this->getQueries()[$idQuery])){
            return null;
        };

        $query = $this->getQueries()[$idQuery];
        $result = $app['pomm'][$query['session_name']]->getQueryManager()->query('explain '.$query['sql'],$query['parameters'] );

        return $app['twig']->render(
            '@Pomm/Profiler/explain.html.twig',
            array(
                'result' => $result,
                'idQuery' => $idQuery
            )
        );
    }

    private function searchNameSessionByDsn($dsn)
    {

    }
}