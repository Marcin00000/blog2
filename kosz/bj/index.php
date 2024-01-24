<?php
$deck = array(
    "2" => 2,
    "3" => 3,
    "4" => 4,
    "5" => 5,
    "6" => 6,
    "7" => 7,
    "8" => 8,
    "9" => 9,
    "10" => 10,
    "J" => 10,
    "Q" => 10,
    "K" => 10,
    "A" => 11
);

function shuffleDeck(&$deck) {
    shuffle($deck);
}

function dealCards(&$deck, $num) {
    $cards = array();
    for ($i = 0; $i < $num; $i++) {
        $cards[] = array_pop($deck);
    }
    return $cards;
}

function calculateSum($cards) {
    $sum = 0;
    foreach ($cards as $card) {
        $sum += $card;
    }
    return $sum;
}

function determineWinner($playerSum, $dealerSum) {
    if ($playerSum > 21) {
        return "Dealer wins!";
    } else if ($dealerSum > 21) {
        return "Player wins!";
    } else if ($playerSum > $dealerSum) {
        return "Player wins!";
    } else if ($playerSum < $dealerSum) {
        return "Dealer wins!";
    } else {
        return "It's a draw!";
    }
}

shuffleDeck($deck);
$playerCards = dealCards($deck, 2);
$dealerCards = dealCards($deck, 2);
$playerSum = calculateSum($playerCards);
$dealerSum = calculateSum($dealerCards);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hit'])) {
        $playerCards[] = array_pop($deck);
        $playerSum = calculateSum($playerCards);
    } else if (isset($_POST['stand'])) {
        while ($dealerSum < 17) {
            $dealerCards[] = array_pop($deck);
            $dealerSum = calculateSum($dealerCards);
        }
    }
}

echo "Player's cards: " . implode(", ", $playerCards) . "<br>";
echo "Player's sum: " . $playerSum . "<br>";
echo "Dealer's cards: " . $dealerCards[0] . ", **<br>";
echo "Dealer's sum: " . $dealerSum . "<br>";
echo determineWinner($playerSum, $dealerSum);
?>
