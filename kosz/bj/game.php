<?php

function createDeck() {
    $deck = [];
    $suits = ['hearts', 'diamonds', 'clubs', 'spades'];
    $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king', 'ace'];

    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $deck[] = [
                'suit' => $suit,
                'value' => $value,
            ];
        }
    }

    return $deck;
}

function dealCards($deck, $num) {
    $cards = [];

    for ($i = 0; $i < $num; $i++) {
        $card = array_pop($deck);
        $cards[] = $card;
    }

    return $cards;
}

function getCardValue($card) {
    if (is_numeric($card['value'])) {
        return (int) $card['value'];
    }

    switch ($card['value']) {
        case 'jack':
        case 'queen':
        case 'king':
            return 10;
        case 'ace':
            return 11;
    }
}

function getHandValue($hand) {
    $aces = 0;
    $total = 0;

    foreach ($hand as $card) {
        $value = getCardValue($card);

        if ($value === 11) {
            $aces++;
        }

        $total += $value;
    }

    while ($aces > 0 && $total > 21) {
        $total -= 10;
        $aces--;
    }

    return $total;
}

function determineWinner($playerHand, $dealerHand) {
    $playerTotal = getHandValue($playerHand);
    $dealerTotal = getHandValue($dealerHand);

    if ($playerTotal > 21) {
        return "lose";
    }

    if ($dealerTotal > 21) {
        return "win";
    }

    if ($playerTotal > $dealerTotal) {
        return "win";
    }

    if ($playerTotal < $dealerTotal) {
        return "lose";
    }

    return "tie";
}

session_start();

if (!isset($_SESSION['deck'])) {
    $_SESSION['deck'] = createDeck();
    shuffle($_SESSION['deck']);
}

$bet = isset($_POST['bet']) ? (int) $_POST['bet'] : 0;
$result = null;

if (isset($_POST['start'])) {
    $playerHand = dealCards($_SESSION['deck'], 2);
    $dealerHand = dealCards($_SESSION['deck'], 2);

    while (true) {
        $playerTotal = getHandValue($playerHand);

        if ($playerTotal === 21) {
            break;
        }

        if ($playerTotal > 21) {
            $result = "lose";
            break;
        }

        if (isset($_POST['hit'])) {
            $playerHand[] = array_pop($_SESSION['deck']);
        } else {
            break;
        }
    }

    if ($result === null) {
        while (getHandValue($dealerHand) < 17) {
            $dealerHand[] = array_pop($_SESSION['deck']);
        }

        $result = determineWinner($playerHand, $dealerHand);
    }

    if ($result === "win") {
        $bet *= 2;
    } else {
        $bet = 0;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack Game</title>
</head>
<body>
<h1>Blackjack Game</h1>

<div>Bet: <?php echo $bet; ?></div>

<?php if ($result !== null): ?>
    <div>Result: <?php echo $result; ?></div>
<?php endif; ?>

<form action="game.php" method="post">
    <button type="submit" name="hit">Hit</button>
    <button type="submit" name="stand">Stand</button>
</form>
</body>
</html>