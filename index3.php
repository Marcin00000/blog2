<?php
session_start();
class BlackjackGame
{
    private $deck = [];
    private $playerCards = [];
    private $dealerCards = [];

    public function __construct()
    {
        $this->initializeDeck();
        $this->shuffleDeck();
        $this->dealInitialCards();
    }

    private function initializeDeck()
    {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->deck[] = ['suit' => $suit, 'value' => $value];
            }
        }
    }

    private function shuffleDeck()
    {
        shuffle($this->deck);
    }

    private function dealInitialCards()
    {
        $this->playerCards = [$this->drawCard(), $this->drawCard()];
        $this->dealerCards = [$this->drawCard(), $this->drawCard()];
    }

    private function drawCard()
    {
        return array_shift($this->deck);
    }

    public function getPlayerCards()
    {
        return $this->playerCards;
    }

    public function getDealerCards()
    {
        return $this->dealerCards;
    }

    public function getPlayerScore()
    {
        return $this->calculateScore($this->playerCards);
    }

    public function getDealerScore()
    {
        return $this->calculateScore($this->dealerCards);
    }

    private function calculateScore($cards)
    {
        $score = 0;
        $numAces = 0;

        foreach ($cards as $card) {
            $value = $card['value'];

            if ($value === 'A') {
                $numAces++;
                $score += 11;
            } elseif (in_array($value, ['K', 'Q', 'J'])) {
                $score += 10;
            } else {
                $score += (int)$value;
            }
        }

        while ($numAces > 0 && $score > 21) {
            $score -= 10;
            $numAces--;
        }

        return $score;
    }

    public function playerHit()
    {
        $this->playerCards[] = $this->drawCard();
    }

    public function dealerHit()
    {
        $this->dealerCards[] = $this->drawCard();
    }

    public function isGameOver()
    {
        return $this->getPlayerScore() >= 21 || $this->getDealerScore() >= 21;
    }

    public function determineWinner()
    {
        $playerScore = $this->getPlayerScore();
        $dealerScore = $this->getDealerScore();

        if ($playerScore > 21 || ($dealerScore <= 21 && $dealerScore >= $playerScore)) {
            return 'Dealer';
        } elseif ($dealerScore > 21 || ($playerScore <= 21 && $playerScore > $dealerScore)) {
            return $_SESSION['name'];
        } else {
            return 'Draw';
        }
    }
    public function resetGame()
    {
        $this->deck = [];
        $this->playerCards = [];
        $this->dealerCards = [];
        $this->initializeDeck();
        $this->shuffleDeck();
        $this->dealInitialCards();
    }
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index2.php">Wpisy</a></li>
            <li><a href="index3.php">Oczko</a></li>
            <li><a href="index.php">ToDo</a></li>
            <li><a href="test/profile.php">Profile</a></li>

        </ul>
    </nav>

    <main>
        <aside>
            <h2>This is Aside</h2>
            <p>This is side content</p>
            <ul>
                <li>author information</li>
                <li>fun facts</li>
                <li>quotes</li>
                <li>external links</li>
                <li>comments</li>
                <li>related content</li>
            </ul>
        </aside>

        <div class="contents">


            <h1>Blackjack Game</h1>

            <?php
            if (!isset($_SESSION['game'])) {
                $_SESSION['game'] = new BlackjackGame();
            } elseif (isset($_POST['reset'])) {
                $_SESSION['game']->resetGame();
            }

            $game = $_SESSION['game'];

            if (isset($_POST['hit'])) {
                $game->playerHit();

                if (!$game->isGameOver() &&  $game->getDealerScore() < 16) {
                    $game->dealerHit();
                }
            } elseif (isset($_POST['stand'])) {
                while ($game->getDealerScore() < 16) {
                    $game->dealerHit();
                }
//                if ($game->getDealerScore() > 16) {
//                    $winner = $game->determineWinner();
//                    echo "Game Over! Winner: $winner";
//                }
            }

            if ($game->isGameOver()||$game->getDealerScore() > 16) {
                $winner = $game->determineWinner();
                echo "Game Over! Winner: $winner";
            }
//            // Wyświetlanie wartości kart dealera
//            echo "Dealer's cards: ";
//            foreach ($game->getDealerCards() as $card) {
//                echo $card['value'] . ', ';
//            }
//            echo "<br>";
            ?>

            <h2>Player Cards</h2>
            <?php foreach ($game->getPlayerCards() as $card): ?>
                <p><?php echo $card['value'] . ' ' . $card['suit']; ?></p>
            <?php endforeach; ?>
            <p>Player Score: <?php echo $game->getPlayerScore(); ?></p>

            <h2>Dealer Cards</h2>
            <?php foreach ($game->getDealerCards() as $index => $card): ?>
                <p><?php echo $game->isGameOver() && $index === 1 ? $card['value'] . ' ' . $card['suit'] : ($index === 1 ? 'Card Hidden' : $card['value'] . ' ' . $card['suit']); ?></p>
            <?php endforeach; ?>
            <p>Dealer Score: <?php echo $game->isGameOver() && $index === 1 ? $game->getDealerScore() : ($index === 1 ? 'Hidden' : $game->getDealerScore()); ?></p>



            <form method="post">
                <button type="submit" name="hit">Hit</button>
                <button type="submit" name="stand">Stand</button>
            </form>

            <form method="post">
                <button type="submit" name="reset">Play Again</button>
            </form>




        </div>

    </main>

    <footer>
        <p>Autor xyz</p>
    </footer>

</div>

</body>
</html>