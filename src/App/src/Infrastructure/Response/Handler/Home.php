<?php

declare(strict_types=1);

namespace App\Infrastructure\Response\Handler;

use App\Domain\Aggregate\Building;
use App\Domain\Command\ChangeBuildingName;
use App\Domain\Command\CreateBuilding;
use App\Domain\Command\UserCheckedIn;
use App\Domain\Command\UserCheckedOut;
use App\Domain\CommandBus;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class Home implements RequestHandlerInterface
{
    public function __construct(private readonly CommandBus $commandBus)
    {
        $response = $this->commandBus->dispatch(CreateBuilding::fromArray([
            'name' => 'Foobar Club'
        ]));

        $result = $response->last(HandledStamp::class)->getResult();
        assert($result instanceof Building);

        $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => $result->id,
            'name' => 'Best you can afford Motel'
        ]));

        $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => $result->id,
            'name' => 'Solo Club!'
        ]));

        $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => $result->id,
            'name' => 'Are you shitting me?'
        ]));

        $this->commandBus->dispatch(UserCheckedIn::toBuilding(
            $result->id,
            'Ben'
        ));

        $this->commandBus->dispatch(UserCheckedIn::toBuilding(
            $result->id,
            'Fritz'
        ));

        $this->commandBus->dispatch(UserCheckedIn::toBuilding(
            $result->id,
            'Marco'
        ));

        $this->commandBus->dispatch(UserCheckedOut::ofBuilding(
            $result->id,
            'Fritz'
        ));

        $this->commandBus->dispatch(UserCheckedIn::toBuilding(
            $result->id,
            'Ben'
        ));

//        $this->commandBus->dispatch(UserCheckedOut::ofBuilding(
//            Uuid::fromString('9071d81f-19ac-46f6-a7b6-6be7753e8e00'),
//            'Marco'
//        ));
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse('Foo');
    }
}