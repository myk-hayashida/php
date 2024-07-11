<?php

function main() {
    $scanner = fopen('php://stdin', 'r');
    $random = new Random();

    echo "じゃんけんゲームを始めます。\n";
    echo "1: グー, 2: チョキ, 3: パー を選んでください。\n";
    echo "数字を入力してください（例: 1）:\n";

    playJanken($scanner, $random);

    echo "ゲームを終了します。\n";
    fclose($scanner);
}

function playJanken($scanner, $random) {
    while (true) {
        $playerHand = getPlayerHand($scanner);

        $computerHand = $random->nextInt(3) + 1;

        echo "あなたの選んだ手: " . handToString($playerHand) . "\n";
        echo "コンピュータの選んだ手: " . handToString($computerHand) . "\n";

        $result = judge($playerHand, $computerHand);

        displayResult($result);

        if (!playAgain($scanner)) {
            break;
        }
    }
}

function getPlayerHand($scanner) {
    while (true) {
        echo "あなたの手を選んでください: ";
        $playerHand = (int) fgets($scanner);

        if ($playerHand < 1 || $playerHand > 3) {
            echo "無効な選択です。1から3の数字を選んでください。\n";
        } else {
            return $playerHand;
        }
    }
}

function handToString($hand) {
    switch ($hand) {
        case 1:
            return "グー";
        case 2:
            return "チョキ";
        case 3:
            return "パー";
        default:
            return "不明";
    }
}

function judge($playerHand, $computerHand) {
    if ($playerHand == $computerHand) {
        return 0; // 引き分け
    } elseif (($playerHand == 1 && $computerHand == 2) ||
              ($playerHand == 2 && $computerHand == 3) ||
              ($playerHand == 3 && $computerHand == 1)) {
        return 1; // プレイヤーの勝ち
    } else {
        return -1; // コンピュータの勝ち
    }
}

function displayResult($result) {
    if ($result == 0) {
        echo "引き分けです。\n";
    } elseif ($result == 1) {
        echo "あなたの勝ちです！\n";
    } else {
        echo "コンピュータの勝ちです。\n";
    }
}

function playAgain($scanner) {
    echo "もう一度遊ぶ場合は y を入力してください。終了する場合はそれ以外のキーを押してください: ";
    $answer = trim(fgets($scanner));
    return strtolower($answer) === 'y';
}

class Random {
    public function nextInt($max) {
        return mt_rand(1, $max);
    }
}

main();

?>
