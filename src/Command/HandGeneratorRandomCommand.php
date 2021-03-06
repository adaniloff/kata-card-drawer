<?php

namespace App\Command;

use App\Facade\CardGameFacadeInterface;
use App\Strategy\FaceAscSortingStrategy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class HandGeneratorRandomCommand extends Command
{
    protected static $defaultName = 'app:hand:generator';

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
            ->addArgument('sort', InputArgument::OPTIONAL, 'The sorting strategy', FaceAscSortingStrategy::NAME)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $quantity = (int)$input->getArgument('quantity');

        $io->text("Building a deck of 52 cards.");
        $deck = $this->game->buildDeck();

        $hand = $this->game->draw($deck, $quantity);

        if ($quantity > count($hand)) {
            $io->warning('You want to draw to much cards !');
        }

        $io->text("Drawing exactly " . count($hand) . " cards.");
        $io->listing($hand->toArray());

        $io->text('There is now ' . count($deck) . ' cards left in the deck.');

        if (0 === count($hand)) {
            $io->warning('You haven\'t drawn a single card !');
        }

        $io->text("Shuffling the hand we just got...");
        $hand = $this->game->shuffle($hand);
        $io->listing($hand->toArray());

        $io->text("And now we sort the hand.");
        $hand = $this->game->sort($hand, $input->getArgument('sort'));
        $io->listing($hand->toArray());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
