<?php

function modPow($base, $exponent, $modulus)
{
    $result = 1;
    while ($exponent > 0) {
        if ($exponent % 2 == 1) {
            $result = ($result * $base) % $modulus;
        }
        $base = ($base * $base) % $modulus;
        $exponent = (int)($exponent / 2);
    }
    return $result;
}

function encRSA($M, $e, $n)
{
    return modPow($M, $e, $n);
}

function decRSA($C, $d, $n)
{
    return modPow($C, $d, $n);
}

// Key generation (replace these with proper RSA key pairs in a real implementation)
$publicKey = array("e" => 7, "n" => 323);
$privateKey = array("d" => 103, "n" => 323);

if (isset($_POST['btnencrypt'])) {
    // Encrypt
    $kalimat = $_POST['encrypt'];

    $enc = '';
    $dec = '';
    for ($i = 0; $i < strlen($kalimat); $i++) {
        $m = ord($kalimat[$i]);
        if ($m <= $publicKey["n"]) {
            $enc = $enc . encRSA($m, $publicKey["e"], $publicKey["n"]) . " ";
        } else {
            $enc = $enc . $m . " ";
        }
    }

    // Decrypt
    $encArray = explode(" ", $enc);
    foreach ($encArray as $item) {
        if (is_numeric($item) && $item <= $publicKey["n"]) {
            $dec = $dec . chr(decRSA($item, $privateKey["d"], $privateKey["n"]));
        } else {
            $dec = $dec . $item;
        }
    }
} elseif (isset($_POST['btndecrypt'])) {
    // Decrypt
    $dec = '';
    $enc = $_POST['decrypt'];
    $encArray = explode(" ", $enc);
    foreach ($encArray as $item) {
        if (is_numeric($item) && $item <= $publicKey["n"]) {
            $dec = $dec . chr(decRSA($item, $privateKey["d"], $privateKey["n"]));
        } else {
            $dec = $dec . $item;
        }
    }
}



// echo "Original: " . $kalimat . "<br>";
// echo "Encrypted: " . $enc . "<br>";
// echo "Decrypted: " . $dec . "<br>";

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .bg {
            width: 100%;
            height: auto;
            min-height: 100vh;
            background-image: url(http://i.imgur.com/w16HASj.png);
            background-size: 100% 100%;
            background-position: top center;
        }

        .content {
            margin-top: 20%;
        }

        .centered {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .InputStyle {
            border-radius: 8px;
            border: solid 1px white;
            background: transparent;
            width: 300px;
            padding: 10px 20px;
            color: white;
        }



        input,
        input::-webkit-input-placeholder {
            font-size: 12px;
            color: white;
        }

        .social-btn {
            position: absolute;
            bottom: 20px;
            left: 47%;
        }

        i {
            padding: 5px;
            color: white;

        }

        input,
        input:focus {
            border: solid 1px white;
            outline: 0;
            -webkit-appearance: none;
            box-shadow: nones;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .secondLine {
            font-weight: 350;
            font-size: 15px;
            margin-bottom: 15%;
            color: white;

        }

        .firstLine {
            font-size: 30px;
            color: white;
        }

        .typing-text {
            color: white;
            font-weight: bold;
            font-size: 30px;
            margin-bottom: 20px;
        }

        @media only screen and (max-width: 600px) {
            .firstLine {
                font-size: 20px;
            }
        }

        .label-rsa {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #cursor {
            animation: blink-caret 0.75s infinite;
        }

        @keyframes blink-caret {
            50% {
                opacity: 0;
            }
        }
    </style>
    <title>Hello, world!</title>
</head>

<body>

    <!--Div for Background-->
    <div class="bg text-center">

        <!--Div for Centered Text & Input-->
        <div class="centered">
            <form action="" method="post">
                <div class="typing-text">
                    <span id="text"></span><span id="cursor">|</span>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?php if (isset($_POST['btnencrypt'])) : ?>
                            <label for="" class="label-rsa">Encrypt</label>
                            <p> <textarea class="InputStyle" name="encrypt" style="font-family:Arial, FontAwesome" type="text"> <?= $dec; ?> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btnencrypt">Encrypt</button>
                        <?php elseif (isset($_POST['btndecrypt'])) :  ?>
                            <label for="" class="label-rsa">Encrypt</label>
                            <p> <textarea class="InputStyle" name="encrypt" style="font-family:Arial, FontAwesome" type="text"> <?= $dec; ?> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btnencrypt">Encrypt</button>
                        <?php else : ?>
                            <label for="" class="label-rsa">Encrypt</label>
                            <p> <textarea class="InputStyle" name="encrypt" style="font-family:Arial, FontAwesome" type="text"> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btnencrypt">Encrypt</button>
                        <?php endif; ?>

                    </div>
                    <div class="col-lg-6">
                        <?php if (isset($_POST['btnencrypt'])) : ?>
                            <label for="" class="label-rsa">Decrypt</label>
                            <p> <textarea class="InputStyle" name="decrypt" style="font-family:Arial, FontAwesome" type="text"> <?= $enc; ?> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btndecrypt">Descrypt</button>
                        <?php elseif (isset($_POST['btndecrypt'])) :  ?>
                            <label class="label-rsa">Decrypt</label>
                            <p> <textarea class="InputStyle" name="decrypt" style="font-family:Arial, FontAwesome" type="text"> <?= $enc; ?> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btndecrypt">Descrypt</button>
                        <?php else : ?>
                            <label class="label-rsa">Encrypt</label>
                            <p> <textarea class="InputStyle" name="decrypt" style="font-family:Arial, FontAwesome" type="text"> </textarea></p>
                            <button type="submit" class="btn btn-outline-light" name="btndecrypt">Decrypt</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        const textElement = document.getElementById('text');
        const textsToType = ['Cyptografy RSA'];
        const typingSpeed = 100; // Kecepatan mengetik (milidetik per karakter)
        const intervalBetweenTexts = 2000; // Jeda antara teks (milidetik)
        let textIndex = 0;
        let charIndex = 0;

        function typeText() {
            const currentText = textsToType[textIndex].slice(0, charIndex);
            textElement.innerHTML = currentText;
            charIndex++;

            if (charIndex <= textsToType[textIndex].length) {
                setTimeout(typeText, typingSpeed);
            } else {
                setTimeout(eraseText, intervalBetweenTexts);
            }
        }

        function eraseText() {
            const currentText = textsToType[textIndex].slice(0, charIndex);
            textElement.innerHTML = currentText;
            charIndex--;

            if (charIndex >= 0) {
                setTimeout(eraseText, typingSpeed);
            } else {
                textIndex++;
                if (textIndex >= textsToType.length) {
                    textIndex = 0; // Mengulangi animasi dari awal setelah semua teks selesai ditampilkan
                }
                setTimeout(typeText, typingSpeed);
            }
        }

        // Mulai animasi ketika halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(typeText, typingSpeed);
        });
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>