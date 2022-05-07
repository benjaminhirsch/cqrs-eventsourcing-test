<?php

declare(strict_types=1);

namespace App\Infrastructure\Response\Handler;

use App\Domain\BuildingRepository;
use App\Domain\Command\ChangeBuildingName;
use App\Domain\Command\CreateBuilding;
use App\Domain\Command\DeleteBuilding;
use App\Domain\Command\UserCheckedIn;
use App\Domain\Command\UserCheckedOut;
use App\Domain\CommandBus;
use Fig\Http\Message\RequestMethodInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

final class Home implements RequestHandlerInterface
{
    public function __construct(private readonly TemplateRendererInterface $renderer, readonly CommandBus $commandBus, private readonly BuildingRepository $buildingRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //var_dump($this->buildingRepository->findBy('df664831-8354-4d77-a5f1-e5df2c987c26'));
        //die;

        $body = $request->getParsedBody();
        if ($request->getMethod() === RequestMethodInterface::METHOD_POST && isset($body['checkIn'])) {
            $this->commandBus->dispatch(UserCheckedIn::toBuilding(Uuid::fromString($body['building']), $body['name']));
            return new RedirectResponse('/');
        }

        if ($request->getMethod() === RequestMethodInterface::METHOD_POST && isset($body['checkOut'])) {
            $this->commandBus->dispatch(UserCheckedOut::ofBuilding(Uuid::fromString($body['building']), $body['name']));
            return new RedirectResponse('/');
        }

        if ($request->getMethod() === RequestMethodInterface::METHOD_POST && isset($body['renameBuilding'])) {
            $this->commandBus->dispatch(ChangeBuildingName::fromArray([
                'id' => Uuid::fromString($body['building']),
                'name' => $body['name']
            ]));
            return new RedirectResponse('/');
        }

        if ($request->getMethod() === RequestMethodInterface::METHOD_POST && isset($body['createBuilding'])) {
            $this->commandBus->dispatch(CreateBuilding::fromArray([
                'name' => $body['name']
            ]));
            return new RedirectResponse('/');
        }

        if ($request->getMethod() === RequestMethodInterface::METHOD_POST && isset($body['deleteBuilding'])) {
            $this->commandBus->dispatch(DeleteBuilding::fromArray([
                'id' => Uuid::fromString($body['building']),
            ]));
            return new RedirectResponse('/');
        }

        return new HtmlResponse($this->renderer->render('app::home-page', [
            'buildings' => $this->buildingRepository->getAllBuilding()
        ]));
    }
}