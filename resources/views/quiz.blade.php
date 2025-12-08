<x-app-layout>
    <x-slot:header>Quiz</x-slot:header>
    <!--I'm so so sorry for the css and Javascript chilling in here but I had no choice ;w; it didn't work otherwise-->
    <body
            style="text-align: center; display: flex; gap: 3vh; flex-direction: column; background: #FCF5EB;">
    <p id="answer" style="visibility:hidden; position: absolute">2</p>
    <section style="margin-top: 6vh;">
        <h1 style="font-size: 2rem;">Upload gelukt!</h1>
        <hr style="background: black; margin-top: 2vh; margin-bottom: 2vh;">
        <p style="margin-left: 15vw; margin-right: 15vw;">Beantwoord de vraag juist voor een glimmende kaart!</p>
    </section>
    <section style="margin-top: 3vh;">
        <form action="{{ route('index') }}" method="GET">
            <h2 style="margin-bottom: 2vh;">Vraag over de gemaakte kaart</h2>
            <div style="display: flex; flex-direction: column; gap: 2vh;">
                <input type="button" value="A) Antwoord A" id="answerA_input"
                       style="background:#0076A8; color:white; border: none; border-radius: 10%; padding: 10px;">
                <input type="button" value="B) Antwoord B" id="answerB_input"
                       style="background:#0076A8; color:white; border: none; border-radius: 10%; padding: 10px;">
                <input type="button" value="C) Antwoord C" id="answerC_input"
                       style="background:#0076A8; color:white; border: none; border-radius: 10%; padding: 10px;">
            </div>
            <div style="margin-top: 3vh">
                <span id="resultAns"></span>
                <p id="explanation" style="color: dimgrey; font-style: italic;"></p>
                <div style="margin-top: 3vh">
                    <input type="submit" value="Verder" id="submitBtn"
                           style="visibility: hidden; border: #63BFB5 2px solid; padding: 10px; background: #319E88">
                </div>
            </div>
        </form>
    </section>
    <script> <!--src="../js/quiz.js" defer-->
        let allInputButtons = document.getElementsByTagName("input");

        document.getElementById("answerA_input").addEventListener("click", function () {
            pressedBtn(0);
        });
        document.getElementById("answerB_input").addEventListener("click", function () {
            pressedBtn(1);
        });
        document.getElementById("answerC_input").addEventListener("click", function () {
            pressedBtn(2);
        });

        let rightButton = parseInt(document.getElementById("answer").innerHTML);
        let resultTitle = document.getElementById("resultAns");
        let explanationElement = document.getElementById("explanation");

        window.addEventListener('load', init);

        function init() {

        }

        function pressedBtn(btnPressed) {
            document.getElementById('resultAns').innerHTML = "Button pressed";
            buttonCheck(btnPressed);

            //disables all buttons
            for (let i = 0; i < allInputButtons; i++) {
                let changeBtn = document.getElementsByTagName("input")[i].id;
                document.getElementById(changeBtn).disabled = true;
            }
        }

        function buttonCheck(btn) {
            if (btn === rightButton) {
                result(true, btn);
            } else {
                result(false, btn);
            }
        }

        function result(result, btnChange) {
            let changeInputBtn = allInputButtons[btnChange].id; //neater way to write it
            if (result) {
                resultTitle.innerHTML = "Correct";
                explanationElement.innerHTML = "Hier is de reden waarom je antwoord goed is";
                document.getElementById(changeInputBtn).style.background = "#16BE00";
            } else if (!result) {
                resultTitle.innerHTML = "Helaas";
                explanationElement.innerHTML = "Dit is niet het goede antwoord. Je hebt wel het kaartje verdiend!";
                document.getElementById(changeInputBtn).style.background = "red";
            }
            document.getElementById('submitBtn').style.visibility = "visible";
        }

    </script>
    </body>
</x-app-layout>
