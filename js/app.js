// Deze functie opent de modal en toont de vraag
function openModal(index) {
  // Zoek het element met de class 'box' en het bijbehorende data-index
  let box = document.querySelector(`.box[data-index='${index}']`);
  //stuurt je terug als je al een vraag hebt beantwoord
  if (box.classList.contains('answered')) {
    alert("Deze vraag heb je al goed beantwoord 🤦‍♂️");
    return;
  }
  currentBox = box;

  // Haal de vraag en het juiste antwoord uit de dataset van de box
  let riddleText = box.dataset.riddle;
  let correctAnswer = box.dataset.answer;

  // Zet de vraagtekst in het modalvenster
  document.getElementById('riddle').innerText = riddleText;

  // Zet het correcte antwoord in de modal, zodat we het later kunnen vergelijken
  document.getElementById('modal').dataset.answer = correctAnswer;

  // Maak het antwoordveld leeg
  document.getElementById('answer').value = '';

  // Toon de overlay en de modal door de display-stijl te veranderen naar 'block'
  document.getElementById('overlay').style.display = 'block';
  document.getElementById('modal').style.display = 'block';
}

// Deze functie sluit de modal en de overlay
function closeModal() {
  // Zet de overlay en modal weer op 'none' zodat ze niet meer zichtbaar zijn
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('modal').style.display = 'none';

  // Maak de feedback tekst leeg
  document.getElementById('feedback').innerText = '';
}
let correctAnswers = 0; 
const totalQuestions = 4;
let currentBox = null;

// Deze functie controleert of het ingevoerde antwoord correct is
function checkAnswer() {
  // Haal het antwoord van de gebruiker op uit het invoerveld en verwijder onnodige spaties
  let userAnswer = document.getElementById('answer').value.trim();

  // Haal het juiste antwoord op uit de modal
  let correctAnswer = document.getElementById('modal').dataset.answer;

  // Haal het feedback element op om de gebruiker te informeren
  let feedback = document.getElementById('feedback');

  // Vergelijk het antwoord van de gebruiker met het juiste antwoord (hoofdlettergevoeligheid negeren)
  if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
    // Als het antwoord juist is, geef positieve feedback
    correctAnswers++;
    feedback.innerText = 'Correct! Goed gedaan!';
    feedback.style.color = 'green';

    if (currentBox) {
      currentBox.classList.add('answered');
      currentBox.style.pointerEvents = 'none';
    }

    // Sluit de modal na 1 seconde
    setTimeout(closeModal, 1000);
  } else {
    // Als het antwoord fout is, geef negatieve feedback
    feedback.innerText = 'Fout, probeer opnieuw!';
    feedback.style.color = 'red';
    setTimeout(death, 1500); // Sluit de modal na 1 seconde
  }

  if (correctAnswers === totalQuestions) {
    document.getElementById('feedback').innerText = 'Je hebt alle vragen goed beantwoord!';
    document.getElementById('feedback').style.color = 'green';
    setTimeout(nextroom, 1000); // Wacht 1 seconde en ga dan naar de volgende kamer
}}

let timeLeft = 60; 
    const timerElement = document.getElementById("timer_countdown");
    const countdown = setInterval(function() {
      timeLeft--;
      timerElement.textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(countdown);
        window.location.href = "verloren.php"; 
      }
    }, 1000);


function nextroom(){
  const currentPath = window.location.pathname;
  if (currentPath.includes("room_1.php")) {
    window.location.href = "room_2.php";
  }
  if (currentPath.includes("room_2.php")) {
    window.location.href = "room_3.php";
  }
  if (currentPath.includes("room_3.php")) {
    // window.location.href = "gewonnen.php";
  }
}
// function death(){
//   const currentPath = window.location.pathname;
//   window.location.href = "verloren.php";}