<?php

namespace App\Command;

use App\Facade\CardGameFacadeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HandGenerateRandomCommand extends Command
{
    protected static $defaultName = 'app:hand:generate-random';

    private $game;

    public function __construct(CardGameFacadeInterface $game)
    {
        $this->game = $game;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Generate a random hand')
            ->addArgument('quantity', InputArgument::REQUIRED, 'The number of cards in your hand')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $quantity = $input->getArgument('quantity');

        $io->text("Building a deck of 52 cards.");
        $deck = $this->game->buildDeck();

        $io->text("Drawing exactly $quantity cards.");
        $hand = $this->game->draw($deck, $quantity);
        $io->listing($hand->toArray());

        $io->text('There is now ' . count($deck) . ' cards left in the deck.');

        $io->text("Shuffling the hand we just got...");
        $hand = $this->game->shuffle($hand);
        $io->listing($hand->toArray());

        $io->text("And now we sort the hand.");
        $hand = $this->game->sort($hand);
        $io->listing($hand->toArray());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
