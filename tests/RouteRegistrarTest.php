<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestFirstController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestSecondController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory\RegistrarTestControllerInSubDirectory;
use ThirdParty\Controllers\ThirdPartyController;

class RouteRegistrarTest extends TestCase
{
    /** @test */
    // public function the_registrar_can_register_a_single_file()
    // {
    //     $this
    //         ->routeRegistrar
    //         ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

    //     $this->assertRegisteredRoutesCount(1);

    //     $this->assertRouteRegistered(
    //         RegistrarTestFirstController::class,
    //         uri: 'first-method',
    //     );
    // }

    /** @test */
    // public function the_registrar_can_apply_config_middlewares_to_all_routes()
    // {
    //     $this
    //         ->routeRegistrar
    //         ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

    //     $this->assertRegisteredRoutesCount(1);

    //     $this->assertRouteRegistered(
    //         RegistrarTestFirstController::class,
    //         uri: 'first-method',
    //         middleware: [AnotherTestMiddleware::class]
    //     );
    // }

    /** @test */
    public function the_registrar_can_register_a_whole_directory()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/Controllers/RouteRegistrar'));

        dump(collect($this->getRouteCollection()->getRoutes())->map(fn ($route) => $route->uri()));

        $this->assertRegisteredRoutesCount(3);

        $this->assertRouteRegistered(
            RegistrarTestFirstController::class,
            uri: 'first-method',
        );

        $this->assertRouteRegistered(
            RegistrarTestSecondController::class,
            uri: 'second-method',
        );

        $this->assertRouteRegistered(
            RegistrarTestControllerInSubDirectory::class,
            uri: 'in-sub-directory',
        );
    }

    /** @test */
    public function the_register_can_register_a_directory_with_defined_namespace()
    {
        require_once(__DIR__ . '/ThirdPartyTestClasses/Controllers/ThirdPartyController.php');
        $this->routeRegistrar
            ->useBasePath($this->getTestPath('ThirdPartyTestClasses/Controllers'))
            ->useRootNamespace('ThirdParty\Controllers\\')
            ->registerDirectory($this->getTestPath('ThirdPartyTestClasses/Controllers'));

        $controller = new ThirdPartyController();
        echo $controller->debugging();

        $this->assertRegisteredRoutesCount(1);
        $this->assertRouteRegistered(
            ThirdPartyController::class,
            uri: 'third-party',
            controllerMethod: 'thirdPartyGetMethod',
        );
    }
}
