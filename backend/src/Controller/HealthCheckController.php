<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/health-check', methods: ['GET'])]
    public function healthCheck(): Response
    {
        var_dump(php_ini_loaded_file(), php_ini_scanned_files());

        return new Response();
    }
}
