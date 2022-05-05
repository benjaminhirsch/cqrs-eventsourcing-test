<?php

declare(strict_types=1);

namespace App\Infrastructure\Response\Handler;

use App\Domain\Aggregate\Building;
use App\Domain\AggregateRepository;
use App\Domain\Command\ChangeBuildingName;
use App\Domain\Command\CreateAccount;
use App\Domain\Command\CreateBuilding;
use App\Domain\CommandBus;
use App\Domain\Query\GetSumAccounts;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class Home implements RequestHandlerInterface
{
    public function __construct(private readonly CommandBus $commandBus, private AggregateRepository $aggregateRepository)
    {
        /*$response = $this->commandBus->dispatch(CreateBuilding::fromArray([
            'name' => 'Foobar Club'
        ]));

        $response = $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => Uuid::fromString('2c210263-2d26-4dcd-9a44-5385c4530c94'),
            'name' => 'Best you can afford Motel'
        ]));

        $result = $response->last(HandledStamp::class)->getResult();
        assert($result instanceof Building);
        $this->aggregateRepository->addAggregateRoot($result);

        $response = $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => Uuid::fromString('2c210263-2d26-4dcd-9a44-5385c4530c94'),
            'name' => 'Solo Club!'
        ]));


        $result = $response->last(HandledStamp::class)->getResult();
        assert($result instanceof Building);

        $this->aggregateRepository->addAggregateRoot($result);*/
        $result = $this->aggregateRepository->findBy('2c210263-2d26-4dcd-9a44-5385c4530c94');

        /*$response = $this->commandBus->dispatch(ChangeBuildingName::fromArray([
            'id' => $result->id,
            'name' => 'Are you shitting me?'
        ]));

        $result = $response->last(HandledStamp::class)->getResult();
        assert($result instanceof Building);

        $this->aggregateRepository->addAggregateRoot($result);*/

        var_dump($result);

        die;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse('Foo');
    }
}