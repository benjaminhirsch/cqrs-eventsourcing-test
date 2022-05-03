<?php

declare(strict_types=1);

namespace App\Infrastructure\Response\Handler;

use App\Domain\Aggregate\Building;
use App\Domain\Command\ChangeBuildingName;
use App\Domain\Command\CreateAccount;
use App\Domain\Command\CreateBuilding;
use App\Domain\CommandBus;
use App\Domain\Query\GetSumAccounts;
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
            'id' => $result->id(),
            'name' => 'OMG It\s working hotel'
        ]));

        $result = $response->last(HandledStamp::class)->getResult();
        assert($result instanceof Building);

        var_dump($result);

        die;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse('Foo');
    }
}