<?php

declare(strict_types=1);

namespace App\Infrastructure\Response\Handler;

use App\Domain\AggregateRepository;
use App\Domain\Command\CreateAccount;
use App\Domain\CommandBus;
use App\Domain\Query\GetSumAccounts;
use App\Domain\QueryBus;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Home implements RequestHandlerInterface
{
    public function __construct(private readonly CommandBus $commandBus, private readonly QueryBus $queryBus)
    {

        // Write
        $account = new CreateAccount(random_int(100000, 900000), 'Benjamin');
        $this->commandBus->dispatch($account);

        $account = new CreateAccount(random_int(100000, 900000), 'Max');
        $this->commandBus->dispatch($account);

        $account = new CreateAccount(random_int(100000, 900000), 'Frieder');
        $this->commandBus->dispatch($account);

        // Read
        var_dump($this->queryBus->dispatch(new GetSumAccounts())->getMessage());
        die;

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse('Foo');
    }
}