<?php

/*
 * This file is part of the DriftPHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Controller;

use React\Promise\FulfilledPromise;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController.
 *
 * You can run this action by making `curl` to /
 */
class DefaultController
{
    /**
     * Default path.
     */
    public function __invoke(Request $request)
    {
        return new FulfilledPromise(
            new JsonResponse([
                'message' => 'DriftPHP is working!',
            ], 200)
        );
    }
}
